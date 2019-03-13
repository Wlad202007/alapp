import Vue from 'vue'
import Vuex from 'vuex'
import Alert from './modules/alert'
import ChangePassword from './modules/change_password'
import Rules from './modules/rules'
import PermissionsIndex from './modules/Permissions'
import PermissionsSingle from './modules/Permissions/single'
import RolesIndex from './modules/Roles'
import RolesSingle from './modules/Roles/single'
import UsersIndex from './modules/Users'
import UsersSingle from './modules/Users/single'
import MessagesIndex from './modules/Messages'
import MessagesSingle from './modules/Messages/single'
import EventsIndex from './modules/Events'
import EventsSingle from './modules/Events/single'

import EventsSinglenew from './modules/Events/singlenew'

import SessionsIndex from './modules/Sessions'
import SessionsSingle from './modules/Sessions/single'
import RatesIndex from './modules/Rates'
import RatesSingle from './modules/Rates/single'
import AnswersIndex from './modules/Answers'
import AnswersSingle from './modules/Answers/single'
import AgendasIndex from './modules/Agendas'
import AgendasIndexevent from './modules/Agendas/indexevent'
import AgendasSingleevent from './modules/Agendas/singleevent'
import AgendasSingle from './modules/Agendas/single'
import SponsorsIndex from './modules/Sponsors'
import SponsorsSingle from './modules/Sponsors/single'
import IndustriesIndex from './modules/Industries'
import IndustriesSingle from './modules/Industries/single'
import PostsIndex from './modules/Posts'
import PostsSingle from './modules/Posts/single'
import LikesIndex from './modules/Likes'
import LikesSingle from './modules/Likes/single'
import CommentsIndex from './modules/Comments'
import CommentsSingle from './modules/Comments/single'
import NotesIndex from './modules/Notes'
import NotesSingle from './modules/Notes/single'
import PlannersIndex from './modules/Planners'
import PlannersSingle from './modules/Planners/single'
import UsersLikesIndex from './modules/UsersLikes'
import UsersLikesSingle from './modules/UsersLikes/single'
import CardsIndex from './modules/Cards'
import CardsSingle from './modules/Cards/single'
import EvaluationsIndex from './modules/Evaluations'
import EvaluationsSingle from './modules/Evaluations/single'
import GroupsIndex from './modules/Groups'
import GroupsSingle from './modules/Groups/single'
import GroupsSinglenew from './modules/Groups/singlenew'
import UsersSinglenew from './modules/Users/singlenew'
Vue.use(Vuex)

const debug = process.env.NODE_ENV !== 'production'

export default new Vuex.Store({
    modules: {
        Alert,
        ChangePassword,
        Rules,
        PermissionsIndex,
        PermissionsSingle,
        RolesIndex,
        RolesSingle,
        UsersIndex,
        UsersSingle,
        MessagesIndex,
        MessagesSingle,
        EventsIndex,
        EventsSingle,
        EventsSinglenew,
        SessionsIndex,
        SessionsSingle,
        RatesIndex,
        RatesSingle,
        AnswersIndex,
        AnswersSingle,
        AgendasIndex,
        AgendasIndexevent,
        AgendasSingleevent,
        AgendasSingle,
        SponsorsIndex,
        SponsorsSingle,
        IndustriesIndex,
        IndustriesSingle,
        PostsIndex,
        PostsSingle,
        LikesIndex,
        LikesSingle,
        CommentsIndex,
        CommentsSingle,
        NotesIndex,
        NotesSingle,
        PlannersIndex,
        PlannersSingle,
        UsersLikesIndex,
        UsersLikesSingle,
        CardsIndex,
        CardsSingle,
        EvaluationsIndex,
        EvaluationsSingle,
        GroupsIndex,
        GroupsSingle,
         GroupsSinglenew,
         UsersSinglenew ,
    },
    strict: debug,
})
