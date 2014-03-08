<?php namespace Album\Controller; use Zend\Mvc\Controller\AbstractActionController,    Zend\View\Model\ViewModel,     Album\Form\AlbumForm,    Doctrine\ORM\EntityManager,    Album\Model\Album,    Functions\Controller\FunctionsController as Functions; class AlbumController extends AbstractActionController{    /**     * @var Doctrine\ORM\EntityManager     */    protected $em;     protected $functions;        function __construct(){       $this->functions = new Functions();    }    public function setEntityManager(EntityManager $em)    {        $this->em = $em;    }     public function getEntityManager()    {        if (null === $this->em) {            $this->em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');        }        return $this->em;    }      public function indexAction()    {           // - Valida Autenticação      //  $this->functions->validAuthentication($this->redirect());                return new ViewModel(array(            'albums' => $this->getEntityManager()->getRepository('Album\Model\Album')->findAll()         ));    }     public function addAction()    {        $form = new AlbumForm();        $form->get('submit')->setAttribute('label', 'Add');         $request = $this->getRequest();        if ($request->isPost()) {            $album = new Album();                        $form->setInputFilter($album->getInputFilter());            $form->setData($request->getPost());            if ($form->isValid()) {                 $album->populate($form->getData());                 $this->getEntityManager()->persist($album);                $this->getEntityManager()->flush();                                return $this->redirect()->toRoute('album');             }        }         return array('form' => $form);    }     public function editAction()    {        $id = (int)$this->getEvent()->getRouteMatch()->getParam('id');        if (!$id) {            return $this->redirect()->toRoute('album', array('action'=>'add'));        }         $album = $this->getEntityManager()->find('Album\Model\Album', $id);         $form = new AlbumForm();        $form->setBindOnValidate(false);        $form->bind($album);        $form->get('submit')->setAttribute('label', 'Edit');                $request = $this->getRequest();        if ($request->isPost()) {            $form->setData($request->getPost());            if ($form->isValid()) {                $form->bindValues();                $this->getEntityManager()->flush();                               return $this->redirect()->toRoute('album');            }        }         return array(            'id' => $id,            'form' => $form,        );    }     public function deleteAction()    {        $id = (int)$this->getEvent()->getRouteMatch()->getParam('id');        if (!$id) {            return $this->redirect()->toRoute('album');        }         $request = $this->getRequest();        if ($request->isPost()) {            $del = $request->getPost()->get('del', 'No');			            if ($del == 'Yes') {              		$id = (int) $request->getPost('id');                $album = $this->getEntityManager()->find('Album\Model\Album', $id);                if ($album) {                    $this->getEntityManager()->remove($album);                    $this->getEntityManager()->flush();                }            }                      return $this->redirect()->toRoute('album', array(                'controller' => 'album',                'action'     => 'index',            ));						        }         return array(            'id' => $id,            'album' => $this->getEntityManager()->find('Album\Model\Album', $id)        );    }}