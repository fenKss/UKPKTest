<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/crutch/", name="crutch_")
 * Class CrutchController
 *
 * @package App\Controller
 */
class CrutchController extends AbstractController
{
    public $path = __DIR__ . "/../../bin/console";

    public function __construct()
    {
        $this->path = realpath($this->path);
    }

    /**
     * @Route("list", name="list")
     */
    public function admin(): Response
    {
        $commands = [
            'crutch_migrations_check'=>"Проверить миграции",
            'crutch_migrations_migrate'=>"Мигрировать",
        ];

        return $this->render('crutch/list.html.twig', [
            'commands'=>$commands
        ]);
    }

    /**
     * @Route("check", name="migrations_check")
     */
    public function check(): Response
    {
        return $this->exec('doctrine:migrations:up-to-date');
    }
    /**
     * @Route("check", name="migrations_migrate")
     */
    public function migrate(): Response
    {
        return $this->exec('doctrine:migrations:migrate');
    }

    private function exec(string $command): Response
    {
        exec($this->path . " ".$command, $out);

        return $this->render('crutch/message.html.twig', [
            "out"=>implode("<br>",$out)
        ]);
    }
}
