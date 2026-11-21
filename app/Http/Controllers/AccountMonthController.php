<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\AccountMonth;
use App\Models\ExtraReceived;
use App\Models\Food;
use App\Models\Payment;
use App\Models\Salary;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AccountMonthController extends Controller
{
    /** Amount columns that make up an account's total. */
    private const AMOUNT_COLUMNS = [
        'tuition', 'tuition_extra', 'one_to_one', 'food', 'transport', 'transport_extra',
        'deposit', 'material', 'registration', 'extra', 'extra_2',
    ];

    public function index(Request $request)
    {
        $account_month = AccountMonth::where('is_active', 1)->orderBy('id', 'DESC')->get();
        foreach ($account_month as $a) {
            $a->total = $a->accounts->sum('total');
            $a->paid = $a->accounts->where('paid', '!=', null)->sum('total');
            $a->extra_received = ExtraReceived::where('month', $a->month)->where('year', $a->year)->sum('amount');
            $a->payment = Payment::where('month', $a->month)->where('year', $a->year)->sum('amount');
            $a->food = Food::where('month', $a->month)->where('year', $a->year)->sum('total');
            $a->salary = Salary::where('month', $a->month)->where('year', $a->year)->sum('employer_total_paid');
            $a->outstanding = $a->paid + $a->extra_received - $a->payment - $a->food - $a->salary;
        }

        return view('account_month.index')->with('account_month', $account_month);
    }

    public function create()
    {
        $account_month = AccountMonth::all();

        return view('account_month.create')->with('account_month', $account_month);
    }

    public function store(Request $request)
    {
        $array = explode('-', $request->month);
        $request->merge(['month' => $array[1], 'year' => $array[0]]);
        $account_month = AccountMonth::create($request->all());

        if ($request->duplicate_from > 0) {
            $findaccount = Account::where('account_month_id', $request->duplicate_from)->get();
            foreach ($findaccount as $acc) {
                $data = ['student_id' => $acc->student_id, 'account_month_id' => $account_month->id];
                foreach (self::AMOUNT_COLUMNS as $col) {
                    $data[$col] = $acc->{$col};
                }
                $data['total'] = $acc->total;
                Account::create($data);
            }
        } else {
            $students = Student::active()->with('school')->get();
            foreach ($students as $s) {
                $this->createPrefilled($s, $account_month);
            }
        }

        return redirect()->route('account_month.index');
    }

    public function sync(AccountMonth $account_month)
    {
        $students = Student::active()->with('school')->get();
        $added = 0;
        foreach ($students as $s) {
            $exists = Account::where('student_id', $s->id)->where('account_month_id', $account_month->id)->exists();
            if (! $exists) {
                $this->createPrefilled($s, $account_month);
                $added++;
            }
        }

        return redirect()->route('account_month.index')
            ->with('success', __(':count new student(s) added to :month.', ['count' => $added, 'month' => $account_month->month.'/'.$account_month->year]));
    }

    /**
     * Refresh unpaid rows of this month from each student's current enrolment.
     * Only services the student is enrolled in are overwritten.
     */
    public function applyFees(AccountMonth $account_month)
    {
        $updated = 0;
        $accounts = $account_month->accounts()->whereNull('paid')->with('student.school')->get();

        foreach ($accounts as $account) {
            if (! $account->student) continue;
            $values = $this->enrolmentValues($account->student, $account_month);
            if (empty($values)) continue;

            $account->fill($values);
            $account->total = $this->sumAmounts($account);
            if ($account->isDirty()) {
                $account->save();
                $updated++;
            }
        }

        return redirect()->route('account_month.edit', $account_month)
            ->with('success', __('Enrolment fees applied to :count unpaid row(s).', ['count' => $updated]));
    }

    public function destroy(AccountMonth $account_month)
    {
        foreach ($account_month->accounts as $a) {
            $a->delete();
        }
        $account_month->delete();

        return redirect()->route('account_month.index');
    }

    public function destroy_specific_acc(Account $account)
    {
        $account->delete();

        return redirect()->back();
    }

    public function edit(AccountMonth $account_month)
    {
        $account_month->load('accounts.student');

        return view('account_month.edit')->with('account_month', $account_month);
    }

    public function update($table_name, $table_value)
    {
        [$column_name, $table_id] = array_pad(explode('~', $table_name), 2, null);
        if ($table_value == 'z') {
            $table_value = null;
        }

        $account = Account::findOrFail($table_id);

        if ($column_name == 'paid' || $column_name == 'sent') {
            $account->update([$column_name => $table_value == 'yes' ? Carbon::now() : null]);

            return ['account' => $account, 'column_name' => 'tr~'.$table_id];
        }

        abort_unless(in_array($column_name, array_merge(self::AMOUNT_COLUMNS, ['remarks']), true), 422);

        $account->update([$column_name => $table_value]);
        $total = $this->sumAmounts($account);
        $account->update(['total' => $total]);

        return ['total' => $total, 'column_name' => 'total~'.$table_id];
    }

    private function createPrefilled(Student $student, AccountMonth $month): Account
    {
        $account = new Account(['student_id' => $student->id, 'account_month_id' => $month->id]);
        $account->fill($this->enrolmentValues($student, $month));
        $account->total = $this->sumAmounts($account) ?: null;
        $account->save();

        return $account;
    }

    /** Bill columns taken from the student's enrolment (only services they actually take). */
    private function enrolmentValues(Student $student, AccountMonth $month): array
    {
        $charges = $student->monthlyCharges((int) $month->year, (int) $month->month);
        $values = [];

        if ($student->daycare) $values['tuition'] = $charges['daycare'];
        if ($student->bath_lunch) $values['food'] = $charges['bath_lunch'];
        if ($student->transport) $values['transport'] = $charges['transport'];
        if ($charges['one_to_one'] > 0) $values['one_to_one'] = $charges['one_to_one'];

        return $values;
    }

    private function sumAmounts(Account $account): float
    {
        return array_sum(array_map(fn ($c) => (float) $account->{$c}, self::AMOUNT_COLUMNS));
    }
}
