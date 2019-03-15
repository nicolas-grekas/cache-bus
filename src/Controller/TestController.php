<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class TestController extends AbstractController
{
    private $didCompute = false;

    /**
     * @Route("/test", name="test")
     */
    public function index(CacheInterface $testCache)
    {
        $this->didCompute = false;
        $s = microtime(1);
        $value = $testCache->get('foo', [$this, 'compute']);

        return $this->render('test/index.html.twig', [
            'value' => $value,
            // red border means we computed the cached value online
            // blue means we were locked by a concurrent process that was processing the value
            // black means we have a cache hit
            'computation' => $this->didCompute ? 'red' : (0.3 < microtime(1) - $s ? 'blue' : 'black'),
        ]);
    }

    function compute(ItemInterface $item)
    {
        sleep(1);
        $item->expiresAfter(5);
        $this->didCompute = true;

        return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
    }
}
