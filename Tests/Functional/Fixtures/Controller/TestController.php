<?php

namespace FOS\HttpCacheBundle\Tests\Functional\Fixtures\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\HttpCacheBundle\Configuration\Tag;

class TestController extends Controller
{
    /**
     * @Tag("all-items")
     * @Tag("item-123")
     */
    public function listAction()
    {
        return new Response('All items including 123');
    }

    /**
     * @Tag(expression="'item-'~id")
     */
    public function itemAction(Request $request, $id)
    {
        if (!$request->isMethodSafe()) {
            $this->container->get('fos_http_cache.cache_manager')->invalidateTags(array('all-items'));
        }

        return new Response('Item ' . $id . ' invalidated');
    }

    /**
     * @Tag("items")
     */
    public function errorAction()
    {
        return new Response('Forbidden', 403);
    }
} 