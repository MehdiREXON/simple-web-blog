<?php

use App\Classes\Request;
use App\Classes\Auth;
use App\Exceptions\{DoesNotExistsException,NotFoundException};
use App\Templates\{CreatePage,DeletePage,EditPage,ErrorPage,PostPage,NotFoundPage};

session_start();

require './vendor/autoload.php';

try
{
    Auth::checkAuthenticated();
    $request = new Request();
    switch($request->get('action'))
    {
        case 'posts':
            $page = new PostPage();
            break;
        case 'logout':
            Auth::logoutUser();
            break;
        case 'create':
            $page = new CreatePage();
            break;
        case 'edit':
            $page = new EditPage();
            break;
        case 'delete':
            $page = new DeletePage();
            break;
        default:
            throw new NotFoundPage("page not found!");
    }
}
catch (DoesNotExistsException | NotFoundException $e)
{
    $page = new NotFoundPage($e->getMessage());
}
catch (Exception $e)
{
    $page = new ErrorPage($e->getMessage());
}
finally
{
    $page->renderPage();
}