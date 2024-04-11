<?php
namespace App\Controller;
use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends AbstractController
{
    #[Route('/modify-task-status', name: 'modify_task_status', methods: ['POST'])]
    public function modifyTaskStatus(Request $request): Response
    {
        $id = $request->request->get('id');
        $newStatus = $request->request->get('statut');

        $entityManager = $this->getDoctrine()->getManager();
        $task = $entityManager->getRepository(Task::class)->find($id);

        if (!$task) {
            throw $this->createNotFoundException('Tâche introuvable pour l\'ID ' . $id);
        }

        // Mettre à jour le statut de la tâche avec le nouveau statut
        $task->setStatut($newStatus);

        // Enregistrer les modifications dans la base de données
        $entityManager->flush();

        // Rediriger vers la vue index
        return $this->redirectToRoute('app_main');
    }
}
