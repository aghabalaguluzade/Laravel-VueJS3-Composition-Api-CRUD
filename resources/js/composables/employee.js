import { ref } from "vue";
import axios from "axios";

export default function useEmployee() {

     const employees = ref([])
     const errors = ref("")
     const success = ref("")
     

     const getEmployees = async () => {
          let response = await axios.get("/api/employees")
          employees.value = response.data.data;
     }

     const destroyeEmployee = async (id) => {
          await axios.delete(`/api/employees/${id}`)
     }

     // const getEmployee = async (id) => {
     //      let respose = await axios.get(`/api/employees/${id}`)
     //      employee.value = respose.data.data;
     // }

     // const updateEmployee = async (id) => {
     //      errors.value = ""
     //      try {
     //           const formdata = new FormData();
     //           formdata.append('id',employee.value.id)
     //           formdata.append('img',employee.value.img)
     //           formdata.append('name',employee.value.name)
     //           formdata.append('email',employee.value.email)
     //           formdata.append('description',employee.value.description)
     //           formdata.append('position',employee.value.position)
     //           formdata.append('salary',employee.value.salary)
     //           let config = 
     //           { headers: { 
     //            'Content-Type': "multipart/form-data; charset=utf-8; boundary=" + Math.random().toString().substr(2),
     //           'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
     //            } }
     //           await axios.put(`/api/employees/${id}`,formdata,config)
     //           await router.push({ name : 'employee.index' })
     //      } catch (error) {
     //           if(error.response.status === 422) {
     //                errors.value = error.response.data.errors;
     //           }
     //      }
     // }

     // const onFileChange = async (e) => {
     //      employee.value = e.target.files[0]
     // }

     return {
          employees,
          getEmployees,
          errors,
          success,
          destroyeEmployee,
     }

}