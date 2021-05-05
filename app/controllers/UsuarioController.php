<?php
require_once './models/Usuario.php';
require_once './interfaces/IApiUsable.php';

class UsuarioController extends Usuario implements IApiUsable
{
    public function CargarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $usuario = $parametros['usuario'];
        $nombre = $parametros['nombre'];
        $clave = $parametros['clave'];

        // Creamos el usuario
        $usr = new Usuario();
        $usr->usuario = $usuario;
        $usr->clave = $clave;
        $usr->nombre = $nombre;

        $retorno = $usr->crearUsuario();

        if($retorno)
        {
          $mensaje = "Usuario $retorno creado con exito";
        }
        else
        {
          $mensaje = "Error";
        }
        
        $payload = json_encode(array("mensaje" => $mensaje));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function Loguear($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $usuario = $parametros['usuario'];
        $clave = $parametros['clave'];

        if(Usuario::verificarCredenciales($usuario, $clave))
        {
          $payload = json_encode(array("mensaje" => "Usuario logueado con exito."));
        }
        else
        {
          $payload = json_encode(array("mensaje" => "Usuario o clave incorrecto."));
        }

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function TraerUno($request, $response, $args)
    {
        // Buscamos usuario por nombre
        $usr = $args['usuario'];
        echo $usr;
        $usuario = Usuario::obtenerUsuario($usr);
        $payload = json_encode($usuario);

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerTodos($request, $response, $args)
    {
        $lista = Usuario::obtenerTodos();
        $payload = json_encode(array("listaUsuario" => $lista));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }
    
    public function ModificarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        if(isset($parametros['id'],$parametros['usuario'],$parametros['nombre'],$parametros['clave']))
        {
          $id = $parametros['id'];
          $usuario = $parametros['usuario'];
          $nombre = $parametros['nombre'];
          $clave = $parametros['clave'];
  
          $usr = new Usuario();
          $usr->id = $id;
          $usr->usuario = $usuario;
          $usr->clave = $clave;
          $usr->nombre = $nombre;

          if ($usr->modificarUsuario()) 
          {
            $mensaje = "Se actualizó el usuario";
          }
          else
          {
            $mensaje = "No se pudo actualizar el usuario";
          }
        }
        else
        {
          $mensaje = "Faltan datos [id-usuario-nombre-clave]";
        }

        $payload = json_encode(array("mensaje" => $mensaje));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function BorrarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();
        if(isset($parametros['usuarioId']))
        {
          $usuarioId = $parametros['usuarioId'];
          $borrados = Usuario::borrarUsuario($usuarioId);
          
          if($borrados == 1)
          {
            $mensaje = "Usuario borrado con exito";
          }
          else if ($borrados == 0)
          {
            $mensaje = "No se encontró usuario que borrar";
          }
          else
          {
            $mensaje = "Se borro mas de un usuario, CORRE";
          }
          
        }
        else
        {
          $mensaje = "Faltan datos";
        }

        $payload = json_encode(array("mensaje" => $mensaje));
        
        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }
}
?>