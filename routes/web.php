<?php

// Route::get('/{any?}', 'PagesController@principal')->where('any', '.*');

Route::middleware('auth')->group(function(){

    Route::get('main', 'PagesController@principal')->name('main')->middleware('auth')->middleware('verified');

    //EMPRESAS
    Route::get('empresas', 'Empresa\EmpresasController@index');
    Route::get('empresas/selectEmpresa', 'Empresa\EmpresasController@selectEmpresa');
    Route::post('empresas/registrar', 'Empresa\EmpresasController@store');
    Route::put('empresas/actualizar', 'Empresa\EmpresasController@update');

    //DEPARTAMENTOS
    Route::get('departamentos', 'DepartamentosController@index');
    Route::get('departamentos/selectDepartamento', 'DepartamentosController@selectDepartamento');
    Route::get('departamentos/selectDepartamentoCopiar/{id}', 'DepartamentosController@selectDepartamentoCopiar');
    Route::post('departamentos/registrar', 'DepartamentosController@store');
    Route::put('departamentos/actualizar', 'DepartamentosController@update');
    Route::get('departamentos/selectDepartamentoReg/{id}', 'DepartamentosController@selectDepartamentoReg');
    

    //DOCUMENTOS
    Route::get('documentos', 'DocumentosController@index');
    Route::get('documentos/selectTipoDocumento', 'DocumentosController@selectTipoDocumento');
    Route::post('documentos/registrar', 'DocumentosController@store');
    Route::put('documentos/actualizar', 'DocumentosController@update');
    Route::get('documentos/correlativos/{id}', 'DocumentosController@correlativo');
    Route::get('documentos/verDocumento/{id}', 'DocumentosController@verDocumento');
    Route::post('documentos/recibir/{id}', 'DocumentosController@recibir');
    Route::post('documentos/derivar/{id}', 'DocumentosController@derivar');
    Route::post('documentos/desderivar/{id}', 'DocumentosController@desDerivar');
    Route::post('documentos/desarchivar/{id}', 'DocumentosController@desArchivar');
    Route::post('documentos/archivar/{id}', 'DocumentosController@archivar');
    Route::get('documentos/pdf/{id}', 'DocumentosController@pdf');

    //ARCHIVADORES
    Route::get('archivadores', 'ArchivadoresController@index');
    Route::post('archivadores/registrar/', 'ArchivadoresController@store');
    Route::put('archivadores/actualizar', 'ArchivadoresController@update');
    Route::get('archivadores/selectArchivador/', 'ArchivadoresController@selectArchivador');
    Route::post('archivadores/agregarCargosEmpresa/{id}', 'ArchivadoresController@AgregarCargosEmpresa');

    //CARGOS
    Route::get('cargos', 'CargosController@index');
    Route::post('cargos/registrar/', 'CargosController@store');
    Route::put('cargos/actualizar', 'CargosController@update');
    Route::get('cargos/selectCargo/{id}', 'CargosController@selectCargo');
    Route::post('cargos/agregarCargosEmpresa/{id}', 'CargosController@AgregarCargosEmpresa');

     //USUARIOS
     Route::get('usuarios', 'UsersController@index');
     Route::post('usuarios/registrar/', 'UsersController@store');
     Route::put('usuarios/actualizar', 'UsersController@update');
     Route::get('usuarios/selectRoles/{id}', 'UsersController@selectRoles');
     Route::post('usuarios/agregarRolesUsuario/{id}', 'UsersController@AgregarRolesUsuario');
     Route::post('usuarios/agregarEmpresasUsuario/{id}', 'UsersController@AgregarEmpresasUsuario');
     Route::get('usuarios/selectEmpresas/{id}', 'UsersController@selectEmpresas');
     Route::get('usuarios/selectRemitente', 'UsersController@selectRemitente');
     Route::get('usuarios/selectUsuarioDepto/{id}', 'UsersController@selectUsuarioDepto');
     

     //ROLES
     Route::get('roles', 'RolesController@index');
     Route::post('roles/registrar/', 'RolesController@store');
     Route::put('roles/actualizar', 'RolesController@update');
     Route::get('roles/selectRoles/{id}', 'RolesController@selectRoles');
     Route::post('roles/agregarPermisosRol/{id}', 'RolesController@AgregarPermisosRol');

     //PERMISOS
     Route::get('permisos', 'PermisosController@index');
     Route::post('permisos/registrar/', 'PermisosController@store');
     Route::put('permisos/actualizar', 'PermisosController@update');
     Route::get('permisos/selectPermisos/{id}', 'PermisosController@selectPermisos');
     Route::post('permisos/agregarPermisosRoles/{id}', 'PermisosController@AgregarPermisosRoles');

    //CATEGORIAS
    Route::get('categorias/selectCategoria', 'CategoriasController@selectCategoria');

    //VACANTES
    Route::post('vacantes/registrar', 'VacantesController@store');
    Route::get('vacantes', 'VacantesController@index');

    //SUCURSALES
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

//Route::get('register/verify/{code}', 'Auth\RegisterController@verify');

//Route::post('enviarEnlace/{id}', 'Auth\LoginController@enviarEnlace');

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');

Route::post('login', 'Auth\LoginController@login');

Route::post('logout', 'Auth\LoginController@logout')->name('logout');


