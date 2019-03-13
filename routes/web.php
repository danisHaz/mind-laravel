<?php

use Illuminate\Support\Facades\Auth;

Route::get('/signin', "SigninController@index")
    ->middleware("guest")
    ->name("signin");

Route::post("/signin", "SigninController@enter")
    ->middleware("guest");

Route::get("/doc/{page?}", "DocController")->where("page",".*");

Route::middleware("auth")->group(function() {
    Route::get("/out", "SigninController@logout");

    Route::get('/', "ProfileController@index")
        ->name("profile");

    Route::get("/setlocale/{locale}", "LocaleController@set");

    Route::prefix("/points")->group(function() {
        Route::get("add", "PointsController@add_index");
        Route::post("add", "PointsController@add");

        Route::get("", "PointsController@mine");

        Route::get("give", "PointsController@give_index");
        Route::post("give", "PointsController@give");

        Route::get("{student}", "PointsController@of_student");

    });

    Route::get("/timetable", "TimetableController@show")
        ->middleware("role:student");

    Route::prefix("/groups")->group(function() {
        Route::get("mine", "GroupController@get_default");
        Route::get("{group}", "GroupController@get");
        Route::get("", "GroupController@all");
    });

    Route::prefix("/questions")->group(function() {
        Route::get("", "QuestionController@show");
        Route::post("store", "QuestionController@store");
        Route::post("answer/{question}", "QuestionController@answer")
            ->middleware("can:answer,question");
        Route::delete("{question}", "QuestionController@delete")
            ->middleware("can:delete,question");
    });

    Route::resource("banners", "BannerController")->except([
        "show"
    ]);

    Route::post("/users/{user}/set_roles", "UserController@setRoles");

    Route::resource("users", "UserController");
    Route::resource("polls", "PollController");
    Route::resource("events", "EventController");
    Route::resource("documents", "DocumentController");

    Route::prefix("/polls")->group(function() {
        Route::post("{poll}/vote/{variant_id}", "PollController@vote");
    });

    Route::prefix("/settings")->group(function() {
        Route::get("", "SettingsController@index");
        Route::post("/change_password", "SettingsController@change_password");
        Route::post("/change_email", "SettingsController@change_email");
    });

    Route::prefix("/data")->group(function() {
        Route::get("", "DataController@index");
        Route::post("", "DataController@upload");
    });

    Route::put("/notifications/{notif}/read", function($notif) {
        $notif = Auth::user()->notifications()->find($notif);
        if ($notif)
            $notif->markAsRead();

        return "";
    });

    Route::get("/marks", "MarksController@index")
         ->middleware("role:student");

    Route::prefix("/email")->group(function() {
        Route::get("", "EmailController@index");
        Route::post("send", "EmailController@send");
    });

    Route::prefix("/status")->group(function() {
        Route::get("", "StatusController@index");
        Route::post("{user}/{status}", "StatusController@set");

        Route::get("statistic", "StatusController@statistic");
    });

    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')
         ->middleware("role:admin");
});
