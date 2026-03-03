!(function (e) {
    function t(e) {
        toastr.success(e, "Event");
    }
    e(document).ready(function () {
        e("#description").summernote({ height: 100 }),
            e("#external-events div.external-event").each(function () {
                var t = { title: e.trim(e(this).text()) };
                e(this).data("eventObject", t), e(this).draggable({ zIndex: 1070, revert: !0, revertDuration: 0 });
            });
        var a = new Date(),
            d = (a.getDate(), a.getMonth(), a.getFullYear(), FullCalendar.Calendar),
            n = FullCalendar.Draggable,
            o = document.getElementById("external-events"),
            r = document.getElementById("drop-remove"),
            l = document.getElementById("calendar");
        e.ajaxSetup({ url: "/calendar-ajax", headers: { "X-CSRF-TOKEN": e('meta[name="csrf-token"]').attr("content") } }),
            new n(o, {
                itemSelector: ".external-event",
                eventData: function (e) {
                    return {
                        id: "new-id",
                        title: e.innerText,
                        backgroundColor: window.getComputedStyle(e, null).getPropertyValue("background-color"),
                        borderColor: window.getComputedStyle(e, null).getPropertyValue("background-color"),
                        textColor: window.getComputedStyle(e, null).getPropertyValue("color"),
                    };
                },
            });
        let s = 0;
        var m = new d(l, {
            headerToolbar: { left: "prev,next today", center: "title", right: "dayGridMonth,timeGridWeek,timeGridDay" },
            themeSystem: "bootstrap",
            events: "/calendar-ajax",
            displayEventTime: !0,
            navLinks: !0,
            selectable: !0,
            editable: !0,
            select: function (t, a, d) {
                e("#calendar table").on("click", function (a) {
                    var d = moment(t.start, "Y-MM-DD").format("Y-MM-DD"),
                        n = moment(t.start, "HH:mm:ss").format("HH:mm:ss"),
                        o = moment(t.end, "Y-MM-DD").format("Y-MM-DD"),
                        r = moment(t.end, "HH:mm:ss").format("HH:mm:ss");
                    e("#add_event #start_date").val(d),
                        e("#add_event #start_time").val(n),
                        e("#add_event #end_date").val(o),
                        e("#add_event #end_time").val(r),
                        e("#add_event #all_day").val(t.allDay),
                        e("#add_event #updateButton").css("display", "none"),
                        e("#add_event #deleteButton").css("display", "none"),
                        e("#add_event #submitButton").css("display", "block"),
                        e("#add_event").modal("show");
                });
            },
            eventDidMount: function (a, d, n, o) {
                "true" === a.event.allDay ? (a.event.allDay = !0) : (a.event.allDay = !1),
                    a.el.addEventListener("click", function () {
                        if (1 === ++s)
                            (oneClickTimer = setTimeout(function () {
                                s = 0;
                                a.event.id;
                                var t = moment(a.event.start, "Y-MM-DD").format("Y-MM-DD"),
                                    d = moment(a.event.start, "HH:mm:ss").format("HH:mm:ss"),
                                    n = moment(a.event.end, "Y-MM-DD").format("Y-MM-DD"),
                                    o = moment(a.event.end, "HH:mm:ss").format("HH:mm:ss");
                                if ("Invalid date" == n && !0 === a.event.allDay)
                                    var r = moment(a.event.start, "Y-MM-DD").add(1, "day").add(0, "hour").format("Y-MM-DD"),
                                        l = moment(a.event.start, "HH:mm:ss").add(0, "day").add(0, "hour").format("HH:mm:ss");
                                else if ("Invalid date" == n && !1 === a.event.allDay)
                                    (r = moment(a.event.start, "Y-MM-DD").add(1, "day").add(0, "hour").format("Y-MM-DD")), (l = moment(a.event.start, "HH:mm:ss").add(0, "day").add(1, "hour").format("HH:mm:ss"));
                                else (r = n), (l = o);

                                e("#add_event #e_title").val(a.event.title),
                                    e("#add_event #start_date").val(t),
                                    e("#add_event #start_time").val(d),
                                    e("#add_event #end_date").val(r),
                                    e("#add_event #end_time").val(l),
                                    e("#add_event #location").val(a.event.extendedProps.location),
                                    e("#add_event textarea#description").summernote("code", a.event.extendedProps.description),
                                    e("#event_user option[value='" + a.event.extendedProps.user + "']").prop("selected", !0),
                                    e("#add_event #event_id").val(a.event.id),
                                    e("#add_event #all_day").val(a.event.allDay),
                                    e("#add_event #deleteButton").css("display", "block"),
                                    e("#add_event #updateButton").css("display", "block"),
                                    e("#add_event #emailButton").css("display", "block"),
                                    e("#add_event #submitButton").css("display", "none"),
                                    e("#add_event").modal("show");
                            }, 400)),
                                document.getElementById("addPost").reset();
                        else if (2 === s) {
                            clearTimeout(oneClickTimer), (s = 0);
                            var d = confirm("Want to email this event?");
                            a.event.id;
                            d &&
                                e.ajax({
                                    type: "POST",
                                    url: "/calendar-email",
                                    data: { id: a.event.id, user: a.event.user, type: "email" },
                                    success: function (e) {
                                        t("Event Successfully Emailed");
                                    },
                                });
                        }
                    });
            },
            editable: !0,
            droppable: !0,
            eventResize: function (a, d, n) {
                var o = moment(a.event.start, "Y-MM-DD HH:mm:ss").format("Y-MM-DD HH:mm:ss"),
                    r = moment(a.event.end, "Y-MM-DD HH:mm:ss").format("Y-MM-DD HH:mm:ss");
                e.ajax({
                    url: "/calendar-edit",
                    data: {
                        id: a.event.id,
                        title: a.event.title,
                        start: o,
                        end: r,
                        backgroundColor: a.event.backgroundColor,
                        borderColor: a.event.borderColor,
                        allDay: a.event.allDay,
                        type: "edit",
                        _token: e('meta[name="csrf-token"]').attr("content"),
                    },
                    type: "POST",
                    success: function (e) {
                        t("Event Updated"), document.getElementById("addPost").reset();
                    },
                });
            },
            eventDrop: function (a, d, n, o) {
                var r = moment(a.event.start, "Y-MM-DD HH:mm:ss").format("Y-MM-DD HH:mm:ss"),
                    l = moment(a.event.end, "Y-MM-DD HH:mm:ss").format("Y-MM-DD HH:mm:ss");
                if ("Invalid date" == l && !0 === a.event.allDay) var s = moment(a.event.start, "Y-MM-DD HH:mm:ss").add(1, "day").add(0, "hour").format("Y-MM-DD HH:mm:ss");
                else if ("Invalid date" == l && !1 === a.event.allDay) s = moment(a.event.start, "Y-MM-DD HH:mm:ss").add(0, "day").add(1, "hour").format("Y-MM-DD HH:mm:ss");
                else s = l;
                e.ajax({
                    url: "/calendar-edit",
                    data: {
                        id: a.event.id,
                        title: a.event.title,
                        start: r,
                        end: s,
                        backgroundColor: a.event.backgroundColor,
                        borderColor: a.event.borderColor,
                        allDay: a.event.allDay,
                        type: "edit",
                        _token: e('meta[name="csrf-token"]').attr("content"),
                    },
                    type: "POST",
                    success: function (e) {
                        t("Event updated"), document.getElementById("addPost").reset();
                    },
                });
            },
            drop: function (a) {
                m.getDate();
                var d = moment(a.date, "Y-MM-DD HH:mm:ss").format("Y-MM-DD HH:mm:ss");
                moment(a.date, "Y-MM-DD HH:mm:ss").format("Y-MM-DD HH:mm:ss");
                let n = "";
                if ("Invalid date") var o = moment(a.date, "Y-MM-DD HH:mm:ss").format("Y-MM-DD HH:mm:ss");
                else o = moment(a.date, "Y-MM-DD HH:mm:ss").format("Y-MM-DD HH:mm:ss");
                e(a.draggedEl).hasClass("general") ? (n = "general") : e(a.draggedEl).hasClass("division") ? (n = "division") : e(a.draggedEl).hasClass("personal") && (n = "personal");
                var l = {
                    title: a.draggedEl.innerText,
                    start: d,
                    end: o,
                    backgroundColor: window.getComputedStyle(a.draggedEl, null).getPropertyValue("background-color"),
                    borderColor: window.getComputedStyle(a.draggedEl, null).getPropertyValue("background-color"),
                    allDay: a.allDay,
                    user: n,
                    type: "create",
                    _token: e('meta[name="csrf-token"]').attr("content"),
                };
                e.ajax({
                    url: "/calendar-add",
                    data: l,
                    type: "POST",
                    success: function (e) {
                        m.getEventById("new-id").remove(), m.refetchEvents(), t("Event added"), document.getElementById("addPost").reset();
                    },
                }),
                    r.checked && a.draggedEl.parentNode.removeChild(a.draggedEl);
            },
        });
        m.render(),
            e("#submitButton").on("click", function (a) {
                a.preventDefault(), e("#add_event").modal("hide");
                var d = e("#add_event #start_date").val(),
                    n = e("#add_event #start_time").val(),
                    o = e("#add_event #end_date").val(),
                    r = e("#add_event #end_time").val(),
                    l = e("#add_event #all_day").val(),
                    s = e("#add_event #add-color-background").val(),
                    v = e("#add_event #add-color-border").val(),
                    z = e("#add_event #location").val();
                    c = e("#add_event #description").val();
                "" == s && "" == v ? ((s = "#3c8dbc"), (v = "#3c8dbc")) : ((s = e("#add_event #add-color-background").val()), (v = e("#add_event #add-color-border").val()));
                var i = e("#add_event #e_title").val(),
                    u = moment(d + " " + n, "Y-MM-DD HH:mm:ss").format("Y-MM-DD HH:mm:ss"),
                    D = moment(o + " " + r, "Y-MM-DD HH:mm:ss").format("Y-MM-DD HH:mm:ss");
                let _ = e("#add_event #event_user").val();
                var y,
                    M = e("select[name='event_user'] :selected").attr("class");
                i && (y = { title: i, user: _, category: M, start: u, end: D, location: z, backgroundColor: s, borderColor: v, allDay: l, description: c, type: "create", _token: e('meta[name="csrf-token"]').attr("content") }),
                    e.ajax({
                        url: "/calendar-add",
                        data: y,
                        type: "POST",
                        success: function (e) {
                            m.refetchEvents(), t("Event added"), document.getElementById("addPost").reset();
                        },
                    });
            }),
            e("#updateButton").on("click", function (a) {
                a.preventDefault(), e("#add_event").modal("hide");
                var d = e("#add_event #start_date").val(),
                    n = e("#add_event #start_time").val(),
                    o = e("#add_event #end_date").val(),
                    r = e("#add_event #end_time").val(),
                    l = e("#add_event #all_day").val(),
                    s = e("#add_event #add-color-background").val(),
                    v = e("#add_event #add-color-border").val(),
                    c = e("#add_event #event_id").val(),
                    i = e("select[name='event_user'] :selected").attr("class"),
                    z = e("#add_event #location").val();
                    u = e("#add_event #description").val(),
                    D = e("#add_event #e_title").val(),
                    _ = moment(d + " " + n, "Y-MM-DD HH:mm:ss").format("Y-MM-DD HH:mm:ss"),
                    y = moment(o + " " + r, "Y-MM-DD HH:mm:ss").format("Y-MM-DD HH:mm:ss");
                let M = e("#add_event #event_user").val();
                var f;
                D && (f = { id: c, title: D, user: M, category: i, start: _, end: y, location: z,  backgroundColor: s, borderColor: v, allDay: l, description: u, type: "edit" }),
                    e.ajax({
                        url: "/calendar-edit",
                        data: f,
                        type: "POST",
                        success: function (e) {
                            m.refetchEvents(), t("Event Updated"), document.getElementById("addPost").reset();
                        },
                    });
            }),
            e("#add_event #deleteButton").on("click", function (a) {
                a.preventDefault();
                var d = confirm("Do you really want to delete?");
                e("#add_event").modal("hide");
                var n = e("#add_event #event_id").val();
                d &&
                    e.ajax({
                        type: "POST",
                        url: "/calendar-delete",
                        data: { id: n, type: "delete" },
                        success: function (e) {
                            m.getEventById(n).remove(), t("Event Deleted Successfully"), document.getElementById("addPost").reset();
                        },
                    });
            }),
            e("#add_event #emailButton").on("click", function (a) {
                a.preventDefault();
                var d = confirm("Want to email this event?"),
                    n = e("#add_event #event_id").val();
                d &&
                    e.ajax({
                        type: "POST",
                        url: "/calendar-email",
                        data: { id: n, type: "email" },
                        success: function (e) {
                            t("Event Successfully Emailed");
                        },
                    });
            }),
            e(".close").on("click", function (e) {
                document.getElementById("addPost").reset();
            });
        var v = "#3c8dbc";
        e("#color-chooser > li > a").click(function (t) {
            t.preventDefault(),
                (v = e(this).css("color")),
                e("#submitButton").css({ "background-color": v, "border-color": v }),
                e("#updateButton").css({ "background-color": v, "border-color": v }),
                e("#add-color-background").val(v),
                e("#add-color-border").val(v);
        });
    });
})(jQuery);
