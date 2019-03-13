<?php

use Illuminate\Database\Seeder;

class PermissionSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            
            ['id' => 1, 'title' => 'user_management_access',],
            ['id' => 2, 'title' => 'permission_access',],
            ['id' => 3, 'title' => 'permission_create',],
            ['id' => 4, 'title' => 'permission_edit',],
            ['id' => 5, 'title' => 'permission_view',],
            ['id' => 6, 'title' => 'permission_delete',],
            ['id' => 7, 'title' => 'role_access',],
            ['id' => 8, 'title' => 'role_create',],
            ['id' => 9, 'title' => 'role_edit',],
            ['id' => 10, 'title' => 'role_view',],
            ['id' => 11, 'title' => 'role_delete',],
            ['id' => 12, 'title' => 'user_access',],
            ['id' => 13, 'title' => 'user_create',],
            ['id' => 14, 'title' => 'user_edit',],
            ['id' => 15, 'title' => 'user_view',],
            ['id' => 16, 'title' => 'user_delete',],
            ['id' => 17, 'title' => 'app_access',],
            ['id' => 18, 'title' => 'message_access',],
            ['id' => 19, 'title' => 'message_create',],
            ['id' => 20, 'title' => 'message_edit',],
            ['id' => 21, 'title' => 'message_view',],
            ['id' => 22, 'title' => 'message_delete',],
            ['id' => 23, 'title' => 'event_access',],
            ['id' => 24, 'title' => 'event_create',],
            ['id' => 25, 'title' => 'event_edit',],
            ['id' => 26, 'title' => 'event_view',],
            ['id' => 27, 'title' => 'event_delete',],
            ['id' => 28, 'title' => 'session_access',],
            ['id' => 29, 'title' => 'session_create',],
            ['id' => 30, 'title' => 'session_edit',],
            ['id' => 31, 'title' => 'session_view',],
            ['id' => 32, 'title' => 'session_delete',],
            ['id' => 33, 'title' => 'rate_access',],
            ['id' => 34, 'title' => 'rate_create',],
            ['id' => 35, 'title' => 'rate_edit',],
            ['id' => 36, 'title' => 'rate_view',],
            ['id' => 37, 'title' => 'rate_delete',],
            ['id' => 38, 'title' => 'answer_access',],
            ['id' => 39, 'title' => 'answer_create',],
            ['id' => 40, 'title' => 'answer_edit',],
            ['id' => 41, 'title' => 'answer_view',],
            ['id' => 42, 'title' => 'answer_delete',],
            ['id' => 43, 'title' => 'agenda_access',],
            ['id' => 44, 'title' => 'agenda_create',],
            ['id' => 45, 'title' => 'agenda_edit',],
            ['id' => 46, 'title' => 'agenda_view',],
            ['id' => 47, 'title' => 'agenda_delete',],
            ['id' => 48, 'title' => 'sponsor_access',],
            ['id' => 49, 'title' => 'sponsor_create',],
            ['id' => 50, 'title' => 'sponsor_edit',],
            ['id' => 51, 'title' => 'sponsor_view',],
            ['id' => 52, 'title' => 'sponsor_delete',],
            ['id' => 53, 'title' => 'industry_access',],
            ['id' => 54, 'title' => 'industry_create',],
            ['id' => 55, 'title' => 'industry_edit',],
            ['id' => 56, 'title' => 'industry_view',],
            ['id' => 57, 'title' => 'industry_delete',],
            ['id' => 58, 'title' => 'post_access',],
            ['id' => 59, 'title' => 'post_create',],
            ['id' => 60, 'title' => 'post_edit',],
            ['id' => 61, 'title' => 'post_view',],
            ['id' => 62, 'title' => 'post_delete',],
            ['id' => 63, 'title' => 'like_access',],
            ['id' => 64, 'title' => 'like_create',],
            ['id' => 65, 'title' => 'like_edit',],
            ['id' => 66, 'title' => 'like_view',],
            ['id' => 67, 'title' => 'like_delete',],
            ['id' => 68, 'title' => 'comment_access',],
            ['id' => 69, 'title' => 'comment_create',],
            ['id' => 70, 'title' => 'comment_edit',],
            ['id' => 71, 'title' => 'comment_view',],
            ['id' => 72, 'title' => 'comment_delete',],
            ['id' => 73, 'title' => 'note_access',],
            ['id' => 74, 'title' => 'note_create',],
            ['id' => 75, 'title' => 'note_edit',],
            ['id' => 76, 'title' => 'note_view',],
            ['id' => 77, 'title' => 'note_delete',],
            ['id' => 78, 'title' => 'planner_access',],
            ['id' => 79, 'title' => 'planner_create',],
            ['id' => 80, 'title' => 'planner_edit',],
            ['id' => 81, 'title' => 'planner_view',],
            ['id' => 82, 'title' => 'planner_delete',],
            ['id' => 83, 'title' => 'users_like_access',],
            ['id' => 84, 'title' => 'users_like_create',],
            ['id' => 85, 'title' => 'users_like_edit',],
            ['id' => 86, 'title' => 'users_like_view',],
            ['id' => 87, 'title' => 'users_like_delete',],
            ['id' => 88, 'title' => 'card_access',],
            ['id' => 89, 'title' => 'card_create',],
            ['id' => 90, 'title' => 'card_edit',],
            ['id' => 91, 'title' => 'card_view',],
            ['id' => 92, 'title' => 'card_delete',],

        ];

        foreach ($items as $item) {
            \App\Permission::create($item);
        }
    }
}
