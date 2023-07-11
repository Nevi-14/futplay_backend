<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Usuarios;
use App\Http\Controllers\Provincias;
use App\Http\Controllers\Cantones;
use App\Http\Controllers\Distritos;
use App\Http\Controllers\Posiciones;
use App\Http\Controllers\Estados;
use App\Http\Controllers\Canchas;
use App\Http\Controllers\Categorias;
use App\Http\Controllers\Horarios;
use App\Http\Controllers\Reservaciones;
use App\Http\Controllers\Equipos;
use App\Http\Controllers\Jugadores;
use App\Http\Controllers\DetalleReservaciones;
use App\Http\Controllers\Solicitudes;
use App\Http\Controllers\HistorialPartidos;
use App\Http\Controllers\HistorialPartidoEquipo;
use App\Http\Controllers\TiposReservaciones;
use App\Http\Controllers\UsuariosGeolocalizacion;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// FINALIZADAS

Route::get('get/provincias', [Provincias::class, 'getProvincias']);
Route::get('get/cantones', [Cantones::class, 'getCantones']);
Route::get('get/distritos', [Distritos::class, 'getDistritos']);
Route::get('get/cantones/provincias/{Cod_Provincia}', [Cantones::class, 'getCantonesProvincias']);
Route::get('get/distritos/cantones/{Cod_Canton}', [Distritos::class, 'getDistritosCantones']);
Route::get('get/posiciones', [Posiciones::class, 'getPosiciones']);
Route::get('get/estados', [Estados::class, 'getEstados']);
Route::get('get/login-in/{value}', [Usuarios::class, 'login']);
Route::get('get/login-in-movil/{value}', [Usuarios::class, 'loginMovil']);
Route::post('post/usuario', [Usuarios::class, 'postUser']);
Route::put('put/usuario/{id}', [Usuarios::class, 'putUser']);
Route::delete('delete/usuario/{Cod_Usuario}', [Usuarios::class, 'deleteUser']);
Route::get('get/tipos/reservaciones', [TiposReservaciones::class, 'getTiposReservaciones']);

//  PENDIENTES
 
Route::get('get/usuario/{Cod_Usuario}', [Usuarios::class, 'getUser']);
Route::get('get/usuarios/foto/{Cod_Usuario}', [Usuarios::class, 'getImage']);


Route::get('get/lista/canchas', [Canchas::class, 'getListaCanchas']);
Route::get('get/canchas/{Cod_Usuario}', [Canchas::class, 'getUsuarioCanchas']);
Route::get('get/perfil/cancha/{Cod_Cancha}', [Canchas::class, 'getPerfilCancha']);
Route::post('post/canchas', [Canchas::class, 'postCancha']);
Route::put('put/canchas/{Cod_Cancha}', [Canchas::class, 'putCancha']);
Route::put('put/estado/cancha/{Cod_Cancha}', [Canchas::class, 'putEstadoCancha']);
Route::post('post/foto/cancha/{Cod_Cancha}', [Canchas::class, 'postFotoCancha']);
Route::get('get/horario/cancha/{Cod_Cancha}', [Horarios::class, 'getHorario']);
Route::post('post/horario/cancha/{Cod_Cancha}', [Horarios::class, 'postHorario']);
Route::put('put/horario/cancha/{Cod_Cancha}', [Horarios::class, 'putHorario']);

Route::delete('delete/cancha/{Cod_Cancha}', [Canchas::class, 'deleteCancha']);
Route::put('put/cancelar/reservacion/{Cod_Reservacion}', [Reservaciones::class, 'cancelarReservacion']);

Route::post('post/foto/usuario/{Cod_Usuario}', [Usuarios::class, 'postFotoUsuario']);
Route::put('put/avatar/usuario/{Cod_Usuario}', [Usuarios::class, 'putUserAvatar']);

//Route::post('post/foto/usuario/{Cod_Usuario}', [Usuarios::class, 'postDurezaEquipo']);


Route::get('get/lista/usuarios/{Cod_Usuario}', [Usuarios::class, 'getUsers']);
Route::get('get/categorias', [Categorias::class, 'getCategorias']);
Route::post('post/usuario', [Usuarios::class, 'postUser']);
 
Route::put('put/usuario/jugador/futplay/{Cod_Usuario}', [Usuarios::class, 'putJugadorFutPlay']);
Route::put('put/usuario/jugador/del/partido/{Cod_Usuario}', [Usuarios::class, 'putJugadorDelPartido']);
Route::put('put/usuario/{id}', [Usuarios::class, 'putUser']);
Route::post('post/forgot/password', [Usuarios::class, 'forgotPassword']);
Route::post('post/correo/reservacion', [Reservaciones::class, 'CorreoReservacion']);



Route::post('post/token/verification', [Usuarios::class, 'tokenVerification']);
Route::post('post/usuario/password', [Usuarios::class, 'putUserPassword']);
Route::get('get/reservaciones/abiertas', [Reservaciones::class, 'getReservacionesAbiertas']);

Route::post('post/reservacion/cancha/{Cod_Cancha}', [Reservaciones::class, 'postReservacion']);
Route::get('get/reservaciones/cancha/{Cod_Cancha}/{Fecha}', [Reservaciones::class, 'getReservacionesCanchaDia']);
Route::get('get/reservaciones/cancha/{Cod_Cancha}/{Fecha_Inicio}/{Fecha_Fin}', [Reservaciones::class, 'getReservacionesCanchaRango']);
Route::get('get/reservaciones/movil/{Cod_Usuario}', [Reservaciones::class, 'getReservacionesMovil']);
Route::delete('delete/reservacion/{Cod_Reservacion}', [Reservaciones::class, 'deleteReservacion']);
Route::get('get/disponibilidad/reservaciones/cancha/{Cod_Cancha}/{Hora_Inicio}/{Hora_Fin}', [Reservaciones::class, 'getVerificarDisponibilidadReservacion']);
Route::post('post/detalle/reservacion/{Cod_Reservacion}', [DetalleReservaciones::class, 'postDetalle']);
 
Route::put('put/detalle/reservacion/{Cod_Reservacion}', [DetalleReservaciones::class, 'putDetalleReservacion']);
Route::put('put/reservacion/{Cod_Reservacion}', [Reservaciones::class, 'putReservacion']);

Route::get('get/lista/equipos/{Cod_Usuario}', [Equipos::class, 'getEquipos']);
Route::get('get/clasificacion/equipos', [Equipos::class, 'getEquiposClasificacion']);
Route::get('get/mis/equipos/{Cod_Usuario}', [Equipos::class, 'getUsuarioEquipos']);
Route::post('post/equipo', [Equipos::class, 'postEquipo']);

Route::post('post/validar/puntaje', [HistorialPartidos::class, 'repararPuntaje']);

Route::get('get/filtro/canchas/{Cod_Provincia}/{Cod_Canton}/{Cod_Distrito}/{Cod_Categoria}', [Canchas::class, 'getFiltroListaCanchas']);

Route::get('get/filtro/usuarios/{Cod_Provincia}/{Cod_Canton}/{Cod_Distrito}/{Cod_Posicion}', [Usuarios::class, 'getFiltroUsuarios']);

Route::get('get/filtro/equipos/{Cod_Provincia}/{Cod_Canton}/{Cod_Distrito}', [Equipos::class, 'getFiltroEquipos']);

Route::post('post/dureza/equipo/{Cod_Equipo}', [Equipos::class, 'postDurezaEquipo']);

Route::put('put/avatar/equipo/{Cod_Equipo}', [Equipos::class, 'putEquipoAvatar']);

Route::get('get/perfil/equipo/{Cod_Equipo}', [Equipos::class, 'getPerfilEquipo']);
Route::post('post/foto/equipo/{Cod_Equipo}', [Equipos::class, 'postFotoEquipo']);
Route::put('put/equipo/{Cod_Equipo}', [Equipos::class, 'putEquipo']);
Route::put('put/estadistica/equipo/{Cod_Equipo}', [Equipos::class, 'putEstadisticaEquipo']);
Route::delete('delete/equipo/{Cod_Equipo}', [Equipos::class, 'deleteEquipo']);
Route::get('get/jugador/{Cod_Usuario}/{Cod_Equipo}', [Jugadores::class, 'getJugador']);
Route::get('get/jugadores/equipo/{Cod_Equipo}', [Jugadores::class, 'getJugadoresEquipos']);
Route::post('post/jugadores/equipo/{Cod_Equipo}', [Jugadores::class, 'postJugador']);
Route::put('put/jugadores/equipo/{Cod_Equipo}', [Jugadores::class, 'putJugador']);
Route::delete('delete/jugadores/equipo/{Cod_Jugador}', [Jugadores::class, 'deleteJugador']);

Route::get('get/solicitudes/recibidas/equipo/{Cod_Equipo}', [Solicitudes::class, 'getSolicitudesRecibidasEquipos']);
Route::get('get/solicitudes/recibidas/usuario/{Cod_Usuario}', [Solicitudes::class, 'getSolicitudesRecibidasUsuarios']);
Route::get('get/solicitudes/enviadas/equipo/{Cod_Equipo}', [Solicitudes::class, 'getSolicitudesEnviadasEquipos']);
Route::get('get/solicitudes/enviadas/usuario/{Cod_Usuario}', [Solicitudes::class, 'getSolicitudesEnviadasUsuarios']);
Route::post('post/solicitudes/equipo/{Cod_Equipo}', [Solicitudes::class, 'postSolicitud']);
Route::put('put/solicitud/{Cod_Solicitud}', [Solicitudes::class, 'putSolicitud']);
Route::get('get/reservaciones/{Fecha_Inicio}/{Fecha_Fin}', [Reservaciones::class, 'getReservaciones']);
Route::get('get/reservacionescancha/{Fecha_Inicio}/{Fecha_Fin}/{Cod_Cancha}', [Reservaciones::class, 'getTodasReservaciones']);
Route::get('get/reservaciones/cancha/{Cod_Cancha}/{Fecha_Inicio}/{Fecha_Fin}/{Cod_Estado}', [Reservaciones::class, 'getReservacionesCancha']);
Route::get('get/reservaciones/usuario/{Cod_Cancha}/{Fecha_Inicio}/{Fecha_Fin}/{Cod_Usuario}', [Reservaciones::class, 'getReservacionesUsuario']);
Route::get('get/reservaciones/enviadas/usuario/{Cod_Usuario}', [Reservaciones::class, 'getReservacionesEnviadas']);
Route::get('get/reservaciones/recibidas/usuario/{Cod_Usuario}', [Reservaciones::class, 'getReservacionesRecibidas']);
Route::get('get/reservaciones/canceladas/usuario/{Cod_Usuario}', [Reservaciones::class, 'getReservacionesCanceladasUsuarios']);

 

Route::get('get/reservaciones/futuras/{Cod_Equipo}/{Fecha}', [Reservaciones::class, 'getReservacionesFuturas']);
Route::get('get/reservaciones/confirmadas/usuario/{Cod_Usuario}', [Reservaciones::class, 'getReservacionesConfirmadas']);
Route::get('get/reservaciones/revision/usuario/{Cod_Usuario}', [Reservaciones::class, 'getReservacionesRevision']);
Route::get('get/reservaciones/historial/usuario/{Cod_Usuario}', [Reservaciones::class, 'getReservacionesHistorial']);
Route::get('get/reservaciones/canceladas', [Reservaciones::class, 'getReservacionesCanceladas']);
Route::get('get/partido/reservacion/{Cod_Reservacion}', [HistorialPartidos::class, 'getHistorialPartidos']);

Route::put('put/partido/codigoqr/{Cod_Partido}', [HistorialPartidos::class, 'putCodigoQR']);

Route::put('put/partido/{Cod_Partido}', [HistorialPartidos::class, 'putPartido']);


Route::put('put/finalizar/partido/{Cod_Reservacion}', [HistorialPartidos::class, 'finalizarPartido']);



// USUARIO GELOCALIZACION

Route::get('get/usuario/geolocalizacion/{Cod_Usuario}', [UsuariosGeolocalizacion::class, 'getUsuarioGeolocalizacion']);
Route::post('post/usuario/geolocalizacion', [UsuariosGeolocalizacion::class, 'postUsuarioGeolocalizacion']);
Route::put('put/usuario/geolocalizacion/{Cod_Usuario}', [UsuariosGeolocalizacion::class, 'putUsuarioGeolocalizacion']);
Route::delete('delete/usuario/geolocalizacion/{Cod_Usuario}', [UsuariosGeolocalizacion::class, 'deleteUsuarioGeocalizacion']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
