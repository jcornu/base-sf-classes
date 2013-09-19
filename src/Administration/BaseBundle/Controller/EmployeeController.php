<?php

namespace Administration\BaseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Administration\BaseBundle\Entity\Employee;
use Administration\BaseBundle\Form\EmployeeType;

class EmployeeController extends Controller
{
	public function indexAction()
	{
		$em = $em = $this->getDoctrine()->getManager();
		$entity = $em->getRepository('BaseBundle:Employee')->findAll();
		
		return $this->render('BaseBundle:Employee:index.html.twig', array(
			'entities' => $entity,
			));
	}

	public function showAction($id)
	{
		$em = $this->getDoctrine()->getManager();
		$entity = $em->getRepository('BaseBundle:Employee')->find($id);

		if (!$entity) {
            throw $this->createNotFoundException('Unable to find Employee entity');
        }

        return $this->render('BaseBundle:Employee:show.html.twig', array(
        	'entity' => $entity,
        	));
	}

	public function newAction()
	{
		$entity = new Employee();
		$form = $this->createForm(new EmployeeType(), $entity);
		return $this->render('BaseBundle:Employee:new.html.twig', array(
			'entity' => $entity,
			'form' => $form->createView()
			));
	}

	public function createAction(Request $request)
	{
		$entity = new Employee();
		$form = $this->createForm(new EmployeeType(), $entity);
		$form->bind($request);

		if($form->isValid())
		{
			$em = $this->getDoctrine()->getManager();
			$em->persist($entity);
			$em->flush();

			$this->get('session')->getFlashBag()->add(
				'succès',
				'L\'utilisateur a été ajouté avec succès!'
			);

			return $this->redirect($this->generateUrl('employee'));
		}
		return $this->render('BaseBundle:Employee:new.html.twig', array());
	}

	public function editAction($id)
	{
		$em = $this->getDoctrine()->getManager();
		$entity = $em->getRepository('BaseBundle:Employee')->find($id);

		if(!$entity)
		{
			throw $this->createNotFoundException('Unable to find an Employee with this id='.$id);
		}

		$editForm = $this->createForm(new EmployeeType, $entity);

		return $this->render('BaseBundle:Employee:edit.html.twig', array(
			'entity' => $entity,
			'edit_form' => $editForm->createView(),
		));
	}

	public function updateAction(Request $request, $id)
	{
		$em = $this->getDoctrine()->getManager();
		$entity = $em->getRepository('BaseBundle:Employee')->find($id);

		$edit_form = $this->createForm(new EmployeeType(), $entity);
		$edit_form->bind($request);

		if($edit_form->isValid())
		{
			$em->persist($entity);
			$em->flush();
			$this->get('session')->getFlashBag()->add('success', 'L\'utilisateur'.$entity->getFirstName().' '.$entity->getLastName().' a été mis à jour');
			return $this->redirect($this->generateUrl('employee'));
		}

		return $this->render('BaseBundle:Employee:edit.html.twig', array(
			'entity' => $entity,
			'edit_form' => $editForm->createView(),
		));
	}

	public function deleteAction($id)
	{
		$em = $this->getDoctrine()->getManager();
		$entity = $em->getRepository('BaseBundle:Employee')->find($id);

		if (!$entity) {
				throw $this->createNotFoundException('Unable to find Bu entity.');
		}

		$em->remove($entity);
		$em->flush();

		$this->get('session')->getFlashBag()->add('success', 'L\'utilisateur '.$entity->getLastName().' a bien été supprimé');

		return $this->redirect($this->generateUrl('employee'));
	}
}
