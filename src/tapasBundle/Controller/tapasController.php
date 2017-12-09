<?php

namespace tapasBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use tapasBundle\Entity\tapas;
use tapasBundle\Form\tapasType;
use Symfony\Component\HttpFoundation\Request;

class tapasController extends Controller
{
    public function indexAction()
    {
        return $this->render('tapasBundle:Carpeta_Tapas:index.html.twig');
    }
    public function crearTapaAction(Request $request)
    {
        $tapa=new tapas();
        $form= $this->createForm(tapasType::class,$tapa,array('boton_insert'=> "Insertar"));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $tapa = $form->getData();

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
             $DB = $this->getDoctrine()->getManager();
             $DB->persist($tapa);
             $DB->flush();

             $repository = $this->getDoctrine()->getRepository('tapasBundle:tapas');
             $id=$tapa->getId();
             $mostrar = $repository->find($id);


            return $this->render('tapasBundle:Carpeta_Tapas:ultimoInsertadoTapas.html.twig',array('idTapa' => $mostrar) );
        }

        return $this->render('tapasBundle:Carpeta_Tapas:crearTapasFormulario.html.twig',array('formulario' => $form->createView() ));
    }

    public function mostrarTapaAction()
    {
        $repository = $this->getDoctrine()->getRepository('tapasBundle:tapas');
        // find *all* alumnos
        $tapas = $repository->findAll();

        return $this->render('tapasBundle:Carpeta_Tapas:muestraTodos.html.twig',array('tablaTapas' => $tapas ));
    }

    public function borrarTapaAction($id)
    {
      $DB = $this->getDoctrine()->getManager();
            $eliminar = $DB->getRepository('tapasBundle:tapas')->find($id);

            if (!$eliminar) {
                throw $this->createNotFoundException(
                    'No se ha encontrado el id: '.$id
                );
            }

            $DB->remove($eliminar);
            $DB->flush();
            return $this->redirectToRoute('tapas_mostrar');
    }

    public function mostrarTapaIdAction($id)
    {

        $repository = $this->getDoctrine()->getRepository('tapasBundle:tapas');

        // find *all* alumnos
        $tapas = $repository->find($id);
          //Te redirecciona donde estan todos los elementos de la tabla
         // if(!$productos){return $this->redirectToRoute('pruebas_muestraProductos');}
         if (!$tapas) {
               throw $this->createNotFoundException(
                   'No se ha encontrado el id : '.$id
               );
           }
        return $this->render('tapasBundle:Carpeta_Tapas:muestraTodosId.html.twig',array('idTapa' => $tapas ));
    }
}
