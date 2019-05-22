<?php

Route::group(['prefix' => '/v1', 'middleware' => ['auth:api'], 'namespace' => 'Api\V1', 'as' => 'api.'], function () {

    Route::get('switch-read-status', 'UsersController@swithchReadStatus');
    Route::get('notifi-read-status', 'UsersController@notifiReadStatus');

    Route::get('shopping-lists', 'ShoppingListsController@index');
    Route::get('shopping-lists/{id}', 'ShoppingListsController@show');
    Route::get('shoppings', 'ShoppingsController@index');
    Route::get('shopping-done/{id}', 'ShoppingsController@shoppingDone');

    Route::post('login', 'UsersController@login')->name('api.login');
    Route::post('register', 'UsersController@register')->name('api.register');




    Route::get('send-viber-msg', 'MessagesController@sendViberMsg');

    Route::get('my_account', 'UsersController@myAccount');
    Route::post('update-profile', 'UsersController@updateProfile');
    Route::post('like-user/{id}', 'UsersLikesController@like');

    Route::post('add_post', 'PostsController@storeAlt');
    Route::post('add_comment', 'CommentsController@store_com');
    Route::post('like_post', 'LikesController@store_like');

    Route::get('my-plans', 'PlannersController@myIndex');
    Route::get('toggle-done/{id}', 'PlannersController@toggleDone');


    Route::get('toggle-join-group/{id}', 'GroupsController@toggleJoin');

    Route::get('my-messages', 'MessagesController@my');
    Route::get('messanger', 'MessagesController@myMessanger');
    Route::get('notifi-unread-messages', 'MessagesController@notifiUnRead');

    Route::get('personal-dialog/{id}', 'MessagesController@personalDialog');
    Route::post('send-personal-msg', 'MessagesController@sendPersonalMsg');
    Route::get('group-dialog/{id}', 'MessagesController@groupDialog');
    Route::post('send-group-msg', 'MessagesController@sendGroupMsg');
    Route::get('toggle-fav-event/{id}', 'EventsController@toggleLike');
    Route::get('send-agenda-request/{id}', 'EventsController@sendAgendaRequest');

    Route::get('all-events', 'EventsController@allIndex');
    Route::get('past-events', 'EventsController@pastIndex');
    Route::get('future-events', 'EventsController@futureIndex');

    Route::get('my-notes', 'NotesController@my');
    Route::get('my-cards', 'CardsController@my');

	 Route::get('agendas_event/{id}', 'AgendasController@indexEvent');
	Route::get('sponsors_event/{id}', 'SponsorsController@indexEvent');

	Route::get('users_group/{id}', 'UsersController@indexGroup');
	Route::get('posts_group/{id}', 'PostsController@indexGroup');

	Route::get('notes_user/{id}', 'NotesController@indexUser');
	Route::get('groups_user/{id}', 'GroupsController@indexUser');
	Route::get('events_user/{id}', 'EventsController@indexUser');
	Route::get('sessions_user/{id}', 'SessionsController@indexUser');
	Route::get('planners_user/{id}', 'PlannersController@indexUser');




	Route::get('group_relation/{group}/{model}/{type}/{id}', 'GroupsController@groupRelation');
	Route::get('user_relation/{user}/{model}/{type}/{id}', 'UsersController@userRelation');
	Route::get('event_relation/{event}/{model}/{type}/{id}', 'EventsController@eventRelation');

	////////////////////////////////////////
	Route::get('session_vote/{type}/{id}/{user}', 'SessionsController@vote');
	Route::get('session_votes/{id}', 'SessionsController@votes');

    Route::post('change-password', 'ChangePasswordController@changePassword')->name('auth.change_password');
    Route::apiResource('rules', 'RulesController', ['only' => ['index']]);
    Route::apiResource('permissions', 'PermissionsController');
    Route::apiResource('roles', 'RolesController');
    Route::apiResource('users', 'UsersController');
    Route::apiResource('messages', 'MessagesController');
    Route::apiResource('events', 'EventsController');
    Route::apiResource('shoppings', 'ShoppingsController');
    Route::apiResource('shopping-lists', 'ShoppingListsController');
    Route::apiResource('sessions', 'SessionsController');
    Route::apiResource('rates', 'RatesController');
    Route::apiResource('answers', 'AnswersController');
    Route::apiResource('agendas', 'AgendasController');
    Route::apiResource('sponsors', 'SponsorsController');
    Route::apiResource('industries', 'IndustriesController');
    Route::apiResource('posts', 'PostsController');
    Route::apiResource('likes', 'LikesController');
    Route::apiResource('comments', 'CommentsController');
    Route::apiResource('notes', 'NotesController');
    Route::apiResource('planners', 'PlannersController');
    Route::apiResource('users-likes', 'UsersLikesController');
    Route::apiResource('cards', 'CardsController');
    Route::apiResource('evaluations', 'EvaluationsController');
    Route::apiResource('groups', 'GroupsController');
	Route::apiResource('votes', 'VotesController');
});
