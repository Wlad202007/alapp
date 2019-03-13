@inject('request', 'Illuminate\Http\Request')
<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <ul class="sidebar-menu">

            <li>
                <a href="{{ url('/') }}">
                    <i class="fa fa-wrench"></i>
                    <span class="title">@lang('quickadmin.qa_dashboard')</span>
                </a>
            </li>

            <li class="treeview" v-if="$can('user_management_access')">
                <a href="#">
                    <i class="fa fa-users"></i>
                    <span>@lang('quickadmin.user-management.title')</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li v-if="$can('permission_access')">
                        <router-link :to="{ name: 'permissions.index' }">
                            <i class="fa fa-briefcase"></i>
                            <span>@lang('quickadmin.permissions.title')</span>
                        </router-link>
                    </li>
                    <li v-if="$can('role_access')">
                        <router-link :to="{ name: 'roles.index' }">
                            <i class="fa fa-briefcase"></i>
                            <span>@lang('quickadmin.roles.title')</span>
                        </router-link>
                    </li>
                    <li v-if="$can('user_access')">
                        <router-link :to="{ name: 'users.index' }">
                            <i class="fa fa-user"></i>
                            <span>@lang('quickadmin.users.title')</span>
                        </router-link>
                    </li>
                </ul>
            </li>
            <li class="treeview" v-if="$can('app_access')">
                <a href="#">
                    <i class="fa fa-window-restore"></i>
                    <span>@lang('quickadmin.app.title')</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li v-if="$can('message_access')">
                        <router-link :to="{ name: 'messages.index' }">
                            <i class="fa fa-envelope-o"></i>
                            <span>@lang('quickadmin.messages.title')</span>
                        </router-link>
                    </li>
                    <li v-if="$can('event_access')">
                        <router-link :to="{ name: 'events.index' }">
                            <i class="fa fa-briefcase"></i>
                            <span>@lang('quickadmin.events.title')</span>
                        </router-link>
                    </li>
                    <li v-if="$can('session_access')">
                        <router-link :to="{ name: 'sessions.index' }">
                            <i class="fa fa-gears"></i>
                            <span>@lang('quickadmin.sessions.title')</span>
                        </router-link>
                    </li>
                    <li v-if="$can('rate_access')">
                        <router-link :to="{ name: 'rates.index' }">
                            <i class="fa fa-gears"></i>
                            <span>@lang('quickadmin.rate.title')</span>
                        </router-link>
                    </li>
                    <li v-if="$can('answer_access')">
                        <router-link :to="{ name: 'answers.index' }">
                            <i class="fa fa-gears"></i>
                            <span>@lang('quickadmin.answers.title')</span>
                        </router-link>
                    </li>
                    <li v-if="$can('agenda_access')">
                        <router-link :to="{ name: 'agendas.index' }">
                            <i class="fa fa-clock-o"></i>
                            <span>@lang('quickadmin.agendas.title')</span>
                        </router-link>
                    </li>
                    <li v-if="$can('sponsor_access')">
                        <router-link :to="{ name: 'sponsors.index' }">
                            <i class="fa fa-flag"></i>
                            <span>@lang('quickadmin.sponsors.title')</span>
                        </router-link>
                    </li>
                    <li v-if="$can('industry_access')">
                        <router-link :to="{ name: 'industries.index' }">
                            <i class="fa fa-bullseye"></i>
                            <span>@lang('quickadmin.industries.title')</span>
                        </router-link>
                    </li>
                    <li v-if="$can('post_access')">
                        <router-link :to="{ name: 'posts.index' }">
                            <i class="fa fa-align-left"></i>
                            <span>@lang('quickadmin.posts.title')</span>
                        </router-link>
                    </li>
                    <li v-if="$can('like_access')">
                        <router-link :to="{ name: 'likes.index' }">
                            <i class="fa fa-thumbs-o-up"></i>
                            <span>@lang('quickadmin.likes.title')</span>
                        </router-link>
                    </li>
                    <li v-if="$can('comment_access')">
                        <router-link :to="{ name: 'comments.index' }">
                            <i class="fa fa-commenting"></i>
                            <span>@lang('quickadmin.comments.title')</span>
                        </router-link>
                    </li>
                    <li v-if="$can('note_access')">
                        <router-link :to="{ name: 'notes.index' }">
                            <i class="fa fa-copy"></i>
                            <span>@lang('quickadmin.notes.title')</span>
                        </router-link>
                    </li>
                    <li v-if="$can('planner_access')">
                        <router-link :to="{ name: 'planners.index' }">
                            <i class="fa fa-arrow-circle-o-right"></i>
                            <span>@lang('quickadmin.planners.title')</span>
                        </router-link>
                    </li>
                    <li v-if="$can('users_like_access')">
                        <router-link :to="{ name: 'users_likes.index' }">
                            <i class="fa fa-star-half-o"></i>
                            <span>@lang('quickadmin.users-likes.title')</span>
                        </router-link>
                    </li>
                    <li v-if="$can('card_access')">
                        <router-link :to="{ name: 'cards.index' }">
                            <i class="fa fa-address-card-o"></i>
                            <span>@lang('quickadmin.cards.title')</span>
                        </router-link>
                    </li>
                    <li v-if="$can('evaluation_access')">
                        <router-link :to="{ name: 'evaluations.index' }">
                            <i class="fa fa-star"></i>
                            <span>@lang('quickadmin.evaluations.title')</span>
                        </router-link>
                    </li>
                    <li v-if="$can('group_access')">
                        <router-link :to="{ name: 'groups.index' }">
                            <i class="fa fa-cubes"></i>
                            <span>@lang('quickadmin.groups.title')</span>
                        </router-link>
                    </li>
                </ul>
            </li>

            <li>
                <router-link :to="{ name: 'auth.change_password' }">
                    <i class="fa fa-key"></i>
                    <span class="title">@lang('quickadmin.qa_change_password')</span>
                </router-link>
            </li>

            <li>
                <a href="#logout" onclick="$('#logout').submit();">
                    <i class="fa fa-arrow-left"></i>
                    <span class="title">@lang('quickadmin.qa_logout')</span>
                </a>
            </li>
        </ul>
    </section>
</aside>