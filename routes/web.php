<?php

// Route::get('/{any?}', 'PagesController@principal')->where('any', '.*');

Route::middleware('auth')->group(function(){

    Route::get('main', 'PagesController@principal')->name('main')->middleware('auth')->middleware('verified');

    //Empresas
    Route::get('empresas', 'Empresa\EmpresasController@index');
    Route::get('empresas/selectEmpresa', 'Empresa\EmpresasController@selectEmpresa');
    Route::post('empresas/registrar', 'Empresa\EmpresasController@store');
    Route::put('empresas/actualizar', 'Empresa\EmpresasController@update');

    //Cargos
    Route::get('cargos', 'CargosController@index');
    Route::post('cargos/registrar/', 'CargosController@store');
    Route::put('cargos/actualizar', 'CargosController@update');
    Route::get('cargos/selectCargo/{id}', 'CargosController@selectCargo');
    Route::post('cargos/agregarCargosEmpresa/{id}', 'CargosController@AgregarCargosEmpresa');

     //Usuarios
     Route::get('usuarios', 'UsersController@index');
     Route::post('usuarios/registrar/', 'UsersController@store');
     Route::put('usuarios/actualizar', 'UsersController@update');
     Route::get('usuarios/selectRoles/{id}', 'UsersController@selectRoles');
     Route::post('usuarios/agregarRolesUsuario/{id}', 'UsersController@AgregarRolesUsuario');
     Route::post('usuarios/agregarEmpresasUsuario/{id}', 'UsersController@AgregarEmpresasUsuario');
     Route::get('usuarios/selectEmpresas/{id}', 'UsersController@selectEmpresas');

     //Roles
     Route::get('roles', 'RolesController@index');
     Route::post('roles/registrar/', 'RolesController@store');
     Route::put('roles/actualizar', 'RolesController@update');
     Route::get('roles/selectRoles/{id}', 'RolesController@selectRoles');
     Route::post('roles/agregarPermisosRol/{id}', 'RolesController@AgregarPermisosRol');

     //Permisos
     Route::get('permisos', 'PermisosController@index');
     Route::post('permisos/registrar/', 'PermisosController@store');
     Route::put('permisos/actualizar', 'PermisosController@update');
     Route::get('permisos/selectPermisos/{id}', 'PermisosController@selectPermisos');
     Route::post('permisos/agregarPermisosRoles/{id}', 'PermisosController@AgregarPermisosRoles');

    //Categorias
    Route::get('categorias/selectCategoria', 'CategoriasController@selectCategoria');

    //Vacantes
    Route::post('vacantes/registrar', 'VacantesController@store');
    Route::get('vacantes', 'VacantesController@index');

    //Sucursales
    Route::get('sucursales/selectSucursal/{id}', 'SucursalesController@selectSucursal');
    Route::post('sucursales/registrar', 'SucursalesController@store');

    //Regiones
    Route::get('regiones/selectRegion', 'RegionesController@selectRegion');

    //Paises
    Route::get('paises/selectPais', 'PaisesController@selectPais');

     //Areas
     Route::get('areas/selectArea', 'AreasController@selectArea');

     //Instituciones
     Route::get('instituciones/selectInstitucion', 'InstitucionesController@selectInstitucion');

    //Ciudades
    Route::get('comunas/selectComuna/{id}', 'ComunasController@selectComuna');

});

Route::get('registro', 'Auth\RegisterController@showRegistrationForm')->name('register');

Route::post('registro', 'Auth\RegisterController@register');

Route::get('register/verify/{code}', 'Auth\RegisterController@verify');

Route::post('enviarEnlace/{id}', 'Auth\LoginController@enviarEnlace');

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');

Route::post('login', 'Auth\LoginController@login');

Route::post('logout', 'Auth\LoginController@logout')->name('logout');


