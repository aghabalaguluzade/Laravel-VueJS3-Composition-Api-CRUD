import { createRouter, createWebHistory } from "vue-router";

import EmployeeIndex from "../components/EmployeeIndex.vue"
import EmployeeCreate from "../components/EmployeeCreate.vue"
import EmployeeEdit from "../components/EmployeeEdit.vue"

     const routes = [
          {
               path : "/dashboard",
               name : "employee.index",
               component : EmployeeIndex
          },
          {
               path : "/create",
               name : "employee.create",
               component : EmployeeCreate
          },
          {
               path : "/edit/:id",
               name : "employee.edit",
               component : EmployeeEdit,
               props : true
          }
     ]

export default createRouter({
     history : createWebHistory(),
     routes
})