<?php
/**
 * Use this file after fetching row from SQL Query
 * Created by PhpStorm.
 * User: WhiteDumb
 * Date: 1/4/2019
 * Time: 6:59 AM
 *
 * e.g : $article[ArticleData::ARTICLE_ID]
 */

class ArticleData
{
    const
        ID = "id",
        AUTHOR = "author",
        TITLE = "title",
        CONTENT = "content",
        CREATION_DATE = "creation_date";
}
class PlanningData
{
    const
        ID = "id",
        PSEUDO = "pseudo",
        DAY = "day",
        GAME = "game",
        SCHEDULE = "schedule";
}
class UserData
{
    const
        PSEUDO = "pseudo",
        PASSWORD = "password",
        GROUP = "user_group",
        ACTIVE = "active",
        EMAIL = "email",
        STREAM_LINK = "stream_link";
}
class GroupData
{
    const
        ID = "id",
        NAME = "name",
        EDIT_PLANNING_SELF = "edit_planning_self",
        EDIT_PLANNING_GLOBAL = "edit_planning_global",
        EDIT_ARTICLE_SELF = "edit_article_self",
        EDIT_ARTICLE_GLOBAL = "edit_article_global",
        EDIT_USER = "edit_user";
}