<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeRequest;
use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return EmployeeResource::collection(Employee::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeeRequest $request)
    {
        if($request->hasFile("img")) {
            $data = $request->validate([
                'name' => ["required"],
                'email' => ["required","email"],
                'description' => ["required"],
                'position' => ["required"],
                'salary' => ["required"],
                'img' => ['image','mimes:png,jpg,jpeg,gif,jfif,webp','max:2048']
            ]);
            $image = $request->file("img");
            $directory = "uploads/";
            $img_name = time(). '.' . $image->getClientOriginalExtension();
            $image->move($directory,$img_name);
            $img_name = $directory.$img_name;
            $data['img'] = $img_name;
            $employee = Employee::create($data);
            return new EmployeeResource($employee);
        }

        $employee = Employee::create($request->validated());
        return new EmployeeResource($employee);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        return new EmployeeResource($employee);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(EmployeeRequest $request, Employee $employee)
    {
        if($request->hasFile("img")) {
            $data = $request->validate([
                'name' => ["required"],
                'email' => ["required","email"],
                'description' => ["required"],
                'position' => ["required"],
                'salary' => ["required"],
                'img' => ['image','mimes:png,jpg,jpeg,gif,jfif,webp','max:2048']
            ]);
            $image = $request->file("img");
            $directory = "uploads/";
            $img_name = time(). '.' . $image->getClientOriginalExtension();
            if(file_exists($employee->img)) {
                unlink($employee->img);
            }
            $image->move($directory,$img_name);
            $img_name = $directory.$img_name;
            $data['img'] = $img_name;
            $employee->update($data);
            return new EmployeeResource($employee);
        }
        
        $employee->update($request->validated());
        return new EmployeeResource($employee);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return response()->noContent();
    }
}
