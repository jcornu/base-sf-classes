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
		$deleteForm = $this->createDeleteForm($id);

		return $this->render('BaseBundle:Employee:edit.html.twig', array(
			'entity' => $entity,
			'edit_form' => $editForm->createView(),
			'delete_form' => $deleteForm->createView(),
		));
	}

	public function updateAction()
	{
		return $this->render('BaseBundle:Employee:index.html.twig', array());
	}

	public function deleteAction()
	{
		return $this->render('BaseBundle:Employee:index.html.twig', array());
	}
}
