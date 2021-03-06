import Vue from 'vue'
import VueRouter from 'vue-router'

import ChangePassword from '../components/ChangePassword.vue'
import PermissionsIndex from '../components/cruds/Permissions/Index.vue'
import PermissionsCreate from '../components/cruds/Permissions/Create.vue'
import PermissionsShow from '../components/cruds/Permissions/Show.vue'
import PermissionsEdit from '../components/cruds/Permissions/Edit.vue'
import RolesIndex from '../components/cruds/Roles/Index.vue'
import RolesCreate from '../components/cruds/Roles/Create.vue'
import RolesShow from '../components/cruds/Roles/Show.vue'
import RolesEdit from '../components/cruds/Roles/Edit.vue'
import UsersIndex from '../components/cruds/Users/Index.vue'
import UsersCreate from '../components/cruds/Users/Create.vue'
import UsersShow from '../components/cruds/Users/Show.vue'
import UsersEdit from '../components/cruds/Users/Edit.vue'
import MessagesIndex from '../components/cruds/Messages/Index.vue'
import MessagesCreate from '../components/cruds/Messages/Create.vue'
import MessagesShow from '../components/cruds/Messages/Show.vue'
import MessagesEdit from '../components/cruds/Messages/Edit.vue'
import EventsIndex from '../components/cruds/Events/Index.vue'
import EventsCreate from '../components/cruds/Events/Create.vue'
import EventsShow from '../components/cruds/Events/Show.vue'

import EventsShownew from '../components/cruds/Events/ShowNew.vue'

import EventsEdit from '../components/cruds/Events/Edit.vue'
import SessionsIndex from '../components/cruds/Sessions/Index.vue'
import SessionsCreate from '../components/cruds/Sessions/Create.vue'
import SessionsShow from '../components/cruds/Sessions/Show.vue'
import SessionsEdit from '../components/cruds/Sessions/Edit.vue'
import RatesIndex from '../components/cruds/Rates/Index.vue'
import RatesCreate from '../components/cruds/Rates/Create.vue'
import RatesShow from '../components/cruds/Rates/Show.vue'
import RatesEdit from '../components/cruds/Rates/Edit.vue'
import AnswersIndex from '../components/cruds/Answers/Index.vue'
import AnswersCreate from '../components/cruds/Answers/Create.vue'
import AnswersShow from '../components/cruds/Answers/Show.vue'
import AnswersEdit from '../components/cruds/Answers/Edit.vue'
import AgendasIndex from '../components/cruds/Agendas/Index.vue'

import AgendasEvent from '../components/cruds/Agendas/Event.vue'
import AgendasEventcreate from '../components/cruds/Agendas/EventCreate.vue'
import AgendasEventedit from '../components/cruds/Agendas/EventEdit.vue'

import AgendasCreate from '../components/cruds/Agendas/Create.vue'
import AgendasShow from '../components/cruds/Agendas/Show.vue'
import AgendasEdit from '../components/cruds/Agendas/Edit.vue'
import SponsorsIndex from '../components/cruds/Sponsors/Index.vue'

//import SponsorsEvent from '../components/cruds/Sponsors/Event.vue'
import SponsorsEventcreate from '../components/cruds/Sponsors/EventCreate.vue'
import SponsorsEventedit from '../components/cruds/Sponsors/EventEdit.vue'

import SponsorsCreate from '../components/cruds/Sponsors/Create.vue'
import SponsorsShow from '../components/cruds/Sponsors/Show.vue'
import SponsorsEdit from '../components/cruds/Sponsors/Edit.vue'
import IndustriesIndex from '../components/cruds/Industries/Index.vue'
import IndustriesCreate from '../components/cruds/Industries/Create.vue'
import IndustriesShow from '../components/cruds/Industries/Show.vue'
import IndustriesEdit from '../components/cruds/Industries/Edit.vue'
import PostsIndex from '../components/cruds/Posts/Index.vue'
import PostsCreate from '../components/cruds/Posts/Create.vue'
import PostsShow from '../components/cruds/Posts/Show.vue'
import PostsEdit from '../components/cruds/Posts/Edit.vue'
import LikesIndex from '../components/cruds/Likes/Index.vue'
import LikesCreate from '../components/cruds/Likes/Create.vue'
import LikesShow from '../components/cruds/Likes/Show.vue'
import LikesEdit from '../components/cruds/Likes/Edit.vue'
import CommentsIndex from '../components/cruds/Comments/Index.vue'
import CommentsCreate from '../components/cruds/Comments/Create.vue'
import CommentsShow from '../components/cruds/Comments/Show.vue'
import CommentsEdit from '../components/cruds/Comments/Edit.vue'
import NotesIndex from '../components/cruds/Notes/Index.vue'
import NotesCreate from '../components/cruds/Notes/Create.vue'
import NotesShow from '../components/cruds/Notes/Show.vue'
import NotesEdit from '../components/cruds/Notes/Edit.vue'
import PlannersIndex from '../components/cruds/Planners/Index.vue'
import PlannersCreate from '../components/cruds/Planners/Create.vue'
import PlannersShow from '../components/cruds/Planners/Show.vue'
import PlannersEdit from '../components/cruds/Planners/Edit.vue'
import UsersLikesIndex from '../components/cruds/UsersLikes/Index.vue'
import UsersLikesCreate from '../components/cruds/UsersLikes/Create.vue'
import UsersLikesShow from '../components/cruds/UsersLikes/Show.vue'
import UsersLikesEdit from '../components/cruds/UsersLikes/Edit.vue'
import CardsIndex from '../components/cruds/Cards/Index.vue'
import CardsCreate from '../components/cruds/Cards/Create.vue'
import CardsShow from '../components/cruds/Cards/Show.vue'
import CardsEdit from '../components/cruds/Cards/Edit.vue'
import EvaluationsIndex from '../components/cruds/Evaluations/Index.vue'
import EvaluationsCreate from '../components/cruds/Evaluations/Create.vue'
import EvaluationsShow from '../components/cruds/Evaluations/Show.vue'
import EvaluationsEdit from '../components/cruds/Evaluations/Edit.vue'
import GroupsIndex from '../components/cruds/Groups/Index.vue'
import GroupsCreate from '../components/cruds/Groups/Create.vue'
import GroupsShow from '../components/cruds/Groups/Show.vue'
import GroupsEdit from '../components/cruds/Groups/Edit.vue'

import UsersGroupcreate from '../components/cruds/Users/GroupCreate.vue'
import UsersGroupedit from '../components/cruds/Users/GroupEdit.vue'
import PostsGroupcreate from '../components/cruds/Posts/GroupCreate.vue'
import PostsGroupedit from '../components/cruds/Posts/GroupEdit.vue'

import NotesUsercreate from '../components/cruds/Notes/UserCreate.vue'
import NotesUseredit from '../components/cruds/Notes/UserEdit.vue'
import GroupsUsercreate from '../components/cruds/Groups/UserCreate.vue'
import GroupsUseredit from '../components/cruds/Groups/UserEdit.vue'
import EventsUsercreate from '../components/cruds/Events/UserCreate.vue'
import EventsUseredit from '../components/cruds/Events/UserEdit.vue'
import SessionsUsercreate from '../components/cruds/Sessions/UserCreate.vue'
import SessionsUseredit from '../components/cruds/Sessions/UserEdit.vue'
import PlannersUsercreate from '../components/cruds/Planners/UserCreate.vue'
import PlannersUseredit from '../components/cruds/Planners/UserEdit.vue'

import GroupsShownew from '../components/cruds/Groups/ShowNew.vue'
import UsersShownew from '../components/cruds/Users/ShowNew.vue'
Vue.use(VueRouter)

const routes = [
    { path: '/change-password', component: ChangePassword, name: 'auth.change_password' },
    { path: '/permissions', component: PermissionsIndex, name: 'permissions.index' },
    { path: '/permissions/create', component: PermissionsCreate, name: 'permissions.create' },
    { path: '/permissions/:id', component: PermissionsShow, name: 'permissions.show' },
    { path: '/permissions/:id/edit', component: PermissionsEdit, name: 'permissions.edit' },
    { path: '/roles', component: RolesIndex, name: 'roles.index' },
    { path: '/roles/create', component: RolesCreate, name: 'roles.create' },
    { path: '/roles/:id', component: RolesShow, name: 'roles.show' },
    { path: '/roles/:id/edit', component: RolesEdit, name: 'roles.edit' },
    { path: '/users', component: UsersIndex, name: 'users.index' },
    { path: '/users/create', component: UsersCreate, name: 'users.create' },
    { path: '/users/:id', component: UsersShow, name: 'users.show' },
    { path: '/users/:id/edit', component: UsersEdit, name: 'users.edit' },
    { path: '/messages', component: MessagesIndex, name: 'messages.index' },
    { path: '/messages/create', component: MessagesCreate, name: 'messages.create' },
    { path: '/messages/:id', component: MessagesShow, name: 'messages.show' },
    { path: '/messages/:id/edit', component: MessagesEdit, name: 'messages.edit' },
    { path: '/events', component: EventsIndex, name: 'events.index' },
    { path: '/events/create', component: EventsCreate, name: 'events.create' },
    { path: '/events/:id', component: EventsShow, name: 'events.show' },
    
    { path: '/events_new/:id', component: EventsShownew, name: 'events.shownew' },
    
    { path: '/events/:id/edit', component: EventsEdit, name: 'events.edit' },
    { path: '/sessions', component: SessionsIndex, name: 'sessions.index' },
    { path: '/sessions/create', component: SessionsCreate, name: 'sessions.create' },
    { path: '/sessions/:id', component: SessionsShow, name: 'sessions.show' },
    { path: '/sessions/:id/edit', component: SessionsEdit, name: 'sessions.edit' },
    { path: '/rates', component: RatesIndex, name: 'rates.index' },
    { path: '/rates/create', component: RatesCreate, name: 'rates.create' },
    { path: '/rates/:id', component: RatesShow, name: 'rates.show' },
    { path: '/rates/:id/edit', component: RatesEdit, name: 'rates.edit' },
    { path: '/answers', component: AnswersIndex, name: 'answers.index' },
    { path: '/answers/create', component: AnswersCreate, name: 'answers.create' },
    { path: '/answers/:id', component: AnswersShow, name: 'answers.show' },
    { path: '/answers/:id/edit', component: AnswersEdit, name: 'answers.edit' },
    
    { path: '/agendas_event/:event', component: AgendasEvent, name: 'agendas.event' },
    { path: '/agendas_event/create/:event', component: AgendasEventcreate, name: 'agendas.event.create' },
    { path: '/agendas_event/:id/edit/:event', component: AgendasEventedit, name: 'agendas.event.edit' },
    
    { path: '/agendas', component: AgendasIndex, name: 'agendas.index' },
    { path: '/agendas/create', component: AgendasCreate, name: 'agendas.create' },
    { path: '/agendas/:id', component: AgendasShow, name: 'agendas.show' },
    { path: '/agendas/:id/edit', component: AgendasEdit, name: 'agendas.edit' },
    
//     { path: '/sponsors_event/:event', component: SponsorsEvent, name: 'sponsors.event' },
    { path: '/sponsors_event/create/:event', component: SponsorsEventcreate, name: 'sponsors.event.create', props: true },
    { path: '/sponsors_event/:id/edit/:event', component: SponsorsEventedit, name: 'sponsors.event.edit' },
  
    
    
    { path: '/sponsors', component: SponsorsIndex, name: 'sponsors.index' },
    { path: '/sponsors/create', component: SponsorsCreate, name: 'sponsors.create' },
    { path: '/sponsors/:id', component: SponsorsShow, name: 'sponsors.show' },
    { path: '/sponsors/:id/edit', component: SponsorsEdit, name: 'sponsors.edit' },
    { path: '/industries', component: IndustriesIndex, name: 'industries.index' },
    { path: '/industries/create', component: IndustriesCreate, name: 'industries.create' },
    { path: '/industries/:id', component: IndustriesShow, name: 'industries.show' },
    { path: '/industries/:id/edit', component: IndustriesEdit, name: 'industries.edit' },
    { path: '/posts', component: PostsIndex, name: 'posts.index' },
    { path: '/posts/create', component: PostsCreate, name: 'posts.create' },
    { path: '/posts/:id', component: PostsShow, name: 'posts.show' },
    { path: '/posts/:id/edit', component: PostsEdit, name: 'posts.edit' },
    { path: '/likes', component: LikesIndex, name: 'likes.index' },
    { path: '/likes/create', component: LikesCreate, name: 'likes.create' },
    { path: '/likes/:id', component: LikesShow, name: 'likes.show' },
    { path: '/likes/:id/edit', component: LikesEdit, name: 'likes.edit' },
    { path: '/comments', component: CommentsIndex, name: 'comments.index' },
    { path: '/comments/create', component: CommentsCreate, name: 'comments.create' },
    { path: '/comments/:id', component: CommentsShow, name: 'comments.show' },
    { path: '/comments/:id/edit', component: CommentsEdit, name: 'comments.edit' },
    { path: '/notes', component: NotesIndex, name: 'notes.index' },
    { path: '/notes/create', component: NotesCreate, name: 'notes.create' },
    { path: '/notes/:id', component: NotesShow, name: 'notes.show' },
    { path: '/notes/:id/edit', component: NotesEdit, name: 'notes.edit' },
    { path: '/planners', component: PlannersIndex, name: 'planners.index' },
    { path: '/planners/create', component: PlannersCreate, name: 'planners.create' },
    { path: '/planners/:id', component: PlannersShow, name: 'planners.show' },
    { path: '/planners/:id/edit', component: PlannersEdit, name: 'planners.edit' },
    { path: '/users-likes', component: UsersLikesIndex, name: 'users_likes.index' },
    { path: '/users-likes/create', component: UsersLikesCreate, name: 'users_likes.create' },
    { path: '/users-likes/:id', component: UsersLikesShow, name: 'users_likes.show' },
    { path: '/users-likes/:id/edit', component: UsersLikesEdit, name: 'users_likes.edit' },
    { path: '/cards', component: CardsIndex, name: 'cards.index' },
    { path: '/cards/create', component: CardsCreate, name: 'cards.create' },
    { path: '/cards/:id', component: CardsShow, name: 'cards.show' },
    { path: '/cards/:id/edit', component: CardsEdit, name: 'cards.edit' },
    { path: '/evaluations', component: EvaluationsIndex, name: 'evaluations.index' },
    { path: '/evaluations/create', component: EvaluationsCreate, name: 'evaluations.create' },
    { path: '/evaluations/:id', component: EvaluationsShow, name: 'evaluations.show' },
    { path: '/evaluations/:id/edit', component: EvaluationsEdit, name: 'evaluations.edit' },
    { path: '/groups', component: GroupsIndex, name: 'groups.index' },
    { path: '/groups/create', component: GroupsCreate, name: 'groups.create' },
    { path: '/groups/:id', component: GroupsShow, name: 'groups.show' },
    { path: '/groups/:id/edit', component: GroupsEdit, name: 'groups.edit' },
    
      { path: '/users_group/create/:group', component: UsersGroupcreate, name: 'users.group.create', props: true },
    { path: '/users_group/:id/edit/:group', component: UsersGroupedit, name: 'users.group.edit' },
  
       { path: '/posts_group/create/:group', component: PostsGroupcreate, name: 'posts.group.create', props: true },
    { path: '/posts_group/:id/edit/:group', component: PostsGroupedit, name: 'posts.group.edit' },
  
       { path: '/notes_user/create/:user', component: NotesUsercreate, name: 'notes.user.create', props: true },
    { path: '/notes_user/:id/edit/:user', component: NotesUseredit, name: 'notes.user.edit' },
  
       { path: '/groups_user/create/:user', component: GroupsUsercreate, name: 'groups.user.create', props: true },
    { path: '/groups_user/:id/edit/:user', component: GroupsUseredit, name: 'groups.user.edit' },
       { path: '/planners_user/create/:user', component: PlannersUsercreate, name: 'planners.user.create', props: true },
    { path: '/planners_user/:id/edit/:user', component: PlannersUseredit, name: 'planners.user.edit' },
       { path: '/sessions_user/create/:user', component: SessionsUsercreate, name: 'sessions.user.create', props: true },
    { path: '/sessions_user/:id/edit/:user', component: SessionsUseredit, name: 'sessions.user.edit' },
       { path: '/events_user/create/:user', component: EventsUsercreate, name: 'events.user.create', props: true },
    { path: '/events_user/:id/edit/:user', component: EventsUseredit, name: 'events.user.edit' },
  
  
  
  
  
   { path: '/groups_new/:id', component: GroupsShownew, name: 'groups.shownew' },
   { path: '/users_new/:id', component: UsersShownew, name: 'users.shownew' },
    
]

export default new VueRouter({
    mode: 'history',
    base: '/admin',
    routes
})
