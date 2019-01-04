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
        ARTICLE_ID = "id",
        ARTICLE_AUTHOR = "author",
        ARTICLE_TITLE = "title",
        ARTICLE_CONTENT = "content",
        ARTICLE_CREATION_DATE = "creation_date";
}
class PlanningData
{
    const
        PLANNING_ID = "id",
        PLANNING_PSEUDO = "pseudo",
        PLANNING_DAY = "day",
        PLANNING_GAME = "game",
        PLANNING_SCHEDULE = "schedule";
}
class UserData
{
    const
        USER_PSEUDO = "pseudo",
        USER_PASSWORD = "password",
        USER_LEVEL = "level",
        USER_ACTIVE = "active",
        USER_EMAIL = "email",
        USER_STREAM_LINK = "stream_link";
}
class LevelData
{
    const
        LEVEL_ID = "id",
        LEVEL_NAME = "name",
        LEVEL_EDIT_PLANNING_SELF = "edit_planning_self",
        LEVEL_EDIT_PLANNING_GLOBAL = "edit_planning_global",
        LEVEL_EDIT_ARTICLE_SELF = "edit_article_self",
        LEVEL_EDIT_ARTICLE_GLOBAL = "edit_article_global",
        LEVEL_EDIT_USER = "edit_user";
}