<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Doctrine\ORM\EntityRepository;
use AppBundle\Form\AddressForm;
use AppBundle\Entity\Address;
use Symfony\Component\Form\Form;

/**
 * Controller for maintaining address book
 */
class AddressBookController extends Controller
{
    /** @var EntityRepository */
    private $repository;

    /** @var \AppBundle\Service\Address\Persister */
    private $persister;

    /** {@inheritdoc} */
    public function setContainer(\Symfony\Component\DependencyInjection\ContainerInterface $container = null)
    {
        parent::setContainer($container);
        $this->repository = $container->get('app.address.repository');
        $this->persister = $container->get('app.address.persister');
    }

    /**
     * @return Response
     */
    public function listAction()
    {
        return $this->render('address_book/list.html.twig');
    }

    /**
     * @return JsonResponse
     */
    public function dataAction()
    {
        return $this->getPayload();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function createAction(Request $request)
    {
        $form = $this->createForm(AddressForm::class);
        $form->submit($request->request->all());
        $this->assertValid($form);
        /** @var Address $entity */
        $address = $form->getData();
        $this->persister->create($address);
        return $this->getPayload();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function updateAction(Request $request)
    {
        $address = $this->lookup($request);
        $form = $this->createForm(AddressForm::class, $address);
        $form->submit($request->request->all());
        $this->assertValid($form);
        $this->persister->update($address);
        return $this->getPayload();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteAction(Request $request)
    {
        $address = $this->lookup($request);
        $this->persister->delete($address);
        return $this->getPayload();
    }

    /**
     * @return JsonResponse
     */
    private function getPayload()
    {
        $data = $this->repository->createQueryBuilder('e')->getQuery()->getArrayResult();
        return new JsonResponse($data);
    }

    /**
     * @param Form $form
     * @throws BadRequestHttpException
     */
    private function assertValid(Form $form)
    {
        if (!$form->isValid()) {
            $errors = [];
            foreach ($form->getErrors(true, true) as $error) {
                $errors[] = $error->getMessage();
            }
            throw new BadRequestHttpException(implode("\n", $errors));
        }
    }

    /**
     * @param Request $request
     * @return Address
     */
    private function lookup(Request $request)
    {
        $id = $request->query->get('id');
        if (!$id) {
            throw new BadRequestHttpException;
        }
        $address = $this->repository->find($request->query->get('id'));
        if (!$address) {
            throw $this->createNotFoundException();
        }
        return $address;
    }
}
