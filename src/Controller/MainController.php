<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Form\ModifyTaskStatusType;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TaskRepository;
use App\Form\ModifyTaskTypeFULL;


class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(Request $request, TaskRepository $taskRepository): Response
    {
        // Récupérer les tâches
        $tasks = $taskRepository->findBy([], ['id' => 'DESC']);
        $tasksFait = $taskRepository->findBy(['statut' => 'Fait'], ['id' => 'DESC']); 
        $tasksEncours = $taskRepository->findBy(['statut' => 'En cours'], ['id' => 'DESC']); 
        
        // Initialiser selectedValue à null
        $selectedValue = null;
    
        // Parcourir les tâches pour déterminer la valeur sélectionnée
        foreach ($tasks as $task) {
            $selectedValue = $task->statut; // Accéder directement à la propriété 'statut'
            break; // Sortir de la boucle après avoir trouvé le premier statut
        }
    
    
        return $this->render('main/index.html.twig', [
            'tasks' => $tasks,
            'tasksFait' => $tasksFait,
            'tasksEncours' => $tasksEncours, // Correction de la variable
            'selectedValue' => $selectedValue, // Ajouter la variable selectedValue dans les paramètres du rendu
        ]);
    }

        #[Route('/create-task', name: 'create_task')]
        public function createTask(Request $request, EntityManagerInterface $entityManager, TaskRepository $taskRepository): Response    {
       
        $tasks = $taskRepository->findBy([], ['id' => 'ASC']);

        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($task);
            $entityManager->flush();

            return $this->redirectToRoute('app_main');
        }

        return $this->render('task/task.html.twig', [
            'form' => $form->createView(),
            'tasks' => $tasks,
            
        ]);
    }

    #[Route('/modify-task/{id}', name: 'modify_task', methods: ['POST'])]
    public function modifyTask(Request $request, EntityManagerInterface $entityManager, $id): Response
    {
        $description = $request->request->get('description');
        $statut = $request->request->get('statut');
        $priority = $request->request->get('priority');
        $selectedValue = $request->query->get('selectedValue'); // Récupérer la valeur sélectionnée
    
        $task = $entityManager->getRepository(Task::class)->find($id);
    
        if (!$task) {
            throw $this->createNotFoundException('Tâche non trouvée');
        }
    
        // Modifier les attributs de la tâche
        $task->setDescription($description);
        $task->setStatut($statut);
        $task->setPriority($priority);
    
        $entityManager->flush();
    
        // Rediriger vers la page appropriée après la modification de la tâche
        return $this->redirectToRoute('app_main', [
            'selectedValue' => $selectedValue, // Ajouter la variable selectedValue dans les paramètres de la redirection
        ]);
    }

         


        #[Route('/delete-task/{id}', name: 'delete_task', methods: ['POST'])]
        public function deleteTask(Request $request, EntityManagerInterface $entityManager, TaskRepository $taskRepository, $id): Response
        {
            $task = $taskRepository->find($id);

            if (!$task) {
                throw $this->createNotFoundException('Tâche introuvable pour l\'ID ' . $id);
            }

            $entityManager->remove($task);
            $entityManager->flush();

            return $this->redirectToRoute('app_main');
        }
}
