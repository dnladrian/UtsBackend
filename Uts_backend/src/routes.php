<?php
use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use Illuminate\Database\Capsule\Manager as Capsule;

return function (App $app) {
    // Mendapatkan semua pasien
    $app->get('/patients', function (Request $request, Response $response, $args) {
        $patients = Capsule::table('patients')->get();
        return $response->withJson($patients);
    });

    // Menambahkan pasien baru
    $app->post('/patients', function (Request $request, Response $response, $args) {
        $data = $request->getParsedBody();
        Capsule::table('patients')->insert([
            'name' => $data['name'],
            'age' => $data['age'],
            'gender' => $data['gender'],
            'status' => $data['status']
        ]);
        return $response->withJson(['status' => 'Patient added successfully']);
    });

    // Mendapatkan data pasien berdasarkan ID
    $app->get('/patients/{id}', function (Request $request, Response $response, $args) {
        $id = $args['id'];
        $patient = Capsule::table('patients')->find($id);
        if ($patient) {
            return $response->withJson($patient);
        } else {
            return $response->withJson(['status' => 'Patient not found'], 404);
        }
    });
};
