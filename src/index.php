<?php
session_start();
require "./vendor/autoload.php";

use App\Classes\Request;
use App\Exceptions\{DoesNotExistsException,NotFoundException};
use App\Templates\{CategoryPage,ErrorPage,LoginPage,MainPage,NotFoundPage,SearchPage,SinglePage};

$request = new Request();

try
{
    switch($request->action)
    {
        case 'single':
            $page = new SinglePage();
            break;
        case 'search':
            $page = new SearchPage();     
            break;
        case 'category':
            $page = new CategoryPage();
            break;
        case 'login':
            $page = new LoginPage();
            break;
        case null:
            $page = new MainPage();
            break;
        default:
            throw new NotFoundException("page not found!");
    }
}
catch (NotFoundException | DoesNotExistsException $e)
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