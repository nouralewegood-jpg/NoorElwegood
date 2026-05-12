$(function () {
    "use strict";

    // تحديث الإشعارات والرسائل كل 30 ثانية
    const updateInterval = 30000; // بالميلي ثانية

    // تحديث الإشعارات
    function updateNotifications() {
        $.ajax({
            url: "/admin/notifications/get-latest",
            type: "GET",
            dataType: "json",
            success: function (data) {
                // تحديث عدد الإشعارات
                const totalNotifications =
                    data.plan_requests.length + data.chatbot_questions.length;

                // إظهار/إخفاء مؤشر الإشعارات الجديدة
                if (totalNotifications > 0) {
                    $("#notifications-dropdown").find(".pulse").show();
                } else {
                    $("#notifications-dropdown").find(".pulse").hide();
                }

                // تحديث عنوان الإشعارات
                $(".main-header-notification .dropdown-title-text").text(
                    `لديك ${totalNotifications} إشعارات غير مقروءة`
                );

                // تفريغ قائمة الإشعارات
                let notificationList = $(".main-notification-list");
                notificationList.empty();

                // إذا لم تكن هناك إشعارات، عرض رسالة
                if (totalNotifications === 0) {
                    notificationList.html(
                        '<div class="p-3 text-center">لا توجد إشعارات جديدة</div>'
                    );
                    return;
                }

                // إضافة طلبات الخطط
                data.plan_requests.forEach(function (request) {
                    let requestItem = `
                        <a class="d-flex p-3 border-bottom" href="/admin/plan-requests/${request.id}">
                            <div class="notifyimg bg-success">
                                <i class="la la-shopping-cart text-white"></i>
                            </div>
                            <div class="mr-3">
                                <h5 class="notification-label mb-1">طلب خطة جديد</h5>
                                <div class="notification-subtext">${request.name} - ${request.plan_name}</div>
                                <div class="notification-subtext">${request.created_at}</div>
                            </div>
                            <div class="mr-auto">
                                <i class="las la-angle-left text-left text-muted"></i>
                            </div>
                        </a>
                    `;
                    notificationList.append(requestItem);
                });

                // إضافة أسئلة الشات بوت
                data.chatbot_questions.forEach(function (question) {
                    let questionItem = `
                        <a class="d-flex p-3 border-bottom" href="/admin/chatbot-questions">
                            <div class="notifyimg bg-warning">
                                <i class="la la-question-circle text-white"></i>
                            </div>
                            <div class="mr-3">
                                <h5 class="notification-label mb-1">سؤال جديد للشات بوت</h5>
                                <div class="notification-subtext">${question.question}</div>
                                <div class="notification-subtext">${question.created_at}</div>
                            </div>
                            <div class="mr-auto">
                                <i class="las la-angle-left text-left text-muted"></i>
                            </div>
                        </a>
                    `;
                    notificationList.append(questionItem);
                });
            },
            error: function () {
                console.log("Error fetching notifications");
            },
        });
    }

    // تحديث الرسائل
    function updateMessages() {
        $.ajax({
            url: "/admin/messages/get-latest",
            type: "GET",
            dataType: "json",
            success: function (data) {
                // تحديث عدد الرسائل
                const unreadCount = data.messages.length;

                // إظهار/إخفاء مؤشر الرسائل الجديدة
                if (unreadCount > 0) {
                    $("#messages-dropdown").find(".pulse-danger").show();
                } else {
                    $("#messages-dropdown").find(".pulse-danger").hide();
                }

                // تحديث عنوان الرسائل
                $(".main-header-message .dropdown-title-text").text(
                    `لديك ${unreadCount} رسائل غير مقروءة`
                );

                // تفريغ قائمة الرسائل
                let messageList = $(".main-message-list");
                messageList.empty();

                // إذا لم تكن هناك رسائل، عرض رسالة
                if (unreadCount === 0) {
                    messageList.html(
                        '<div class="p-3 text-center">لا توجد رسائل جديدة</div>'
                    );
                    return;
                }

                // إضافة الرسائل
                data.messages.forEach(function (message) {
                    let firstLetter = message.name.charAt(0);
                    let messageItem = `
                        <a href="/admin/messages/${message.id}" class="p-3 d-flex border-bottom">
                            <div class="drop-img cover-image bg-primary rounded-circle">
                                <span class="avatar-status bg-teal"></span>
                                <span class="text-white font-weight-bold" style="position: relative; top: 7px; right: 10px;">
                                    ${firstLetter}
                                </span>
                            </div>
                            <div class="wd-90p">
                                <div class="d-flex">
                                    <h5 class="mb-1 name">${message.name}</h5>
                                </div>
                                <p class="mb-0 desc">${message.message}</p>
                                <p class="time mb-0 text-left float-right mr-2 mt-2">${message.created_at}</p>
                            </div>
                        </a>
                    `;
                    messageList.append(messageItem);
                });
            },
            error: function () {
                console.log("Error fetching messages");
            },
        });
    }

    // تمييز جميع الإشعارات كمقروءة
    $(document).on("click", "#mark-all-read", function (e) {
        e.preventDefault();
        e.stopPropagation();

        $.ajax({
            url: "/admin/notifications/mark-all-read",
            type: "POST",
            data: {
                _token: $('meta[name="csrf-token"]').attr("content"),
            },
            success: function () {
                updateNotifications();
            },
        });
    });

    // تمييز جميع الرسائل كمقروءة
    $(document).on("click", "#mark-messages-read", function (e) {
        e.preventDefault();
        e.stopPropagation();

        $.ajax({
            url: "/admin/messages/mark-all-read",
            type: "POST",
            data: {
                _token: $('meta[name="csrf-token"]').attr("content"),
            },
            success: function () {
                updateMessages();
            },
        });
    });

    // التحديث الأولي
    updateNotifications();
    updateMessages();

    // تشغيل التحديث الدوري
    setInterval(function () {
        updateNotifications();
        updateMessages();
    }, updateInterval);
});
