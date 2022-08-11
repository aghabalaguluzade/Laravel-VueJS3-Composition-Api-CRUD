<template>

    <div v-if="errors">
        <div v-for="(v,k) in errors" :key="k">
            <p v-for="error in v" :key="error" class="text-sm alert alert-danger">
                {{ error }}
            </p>
        </div>
    </div>

      <form class="space-y-6" v-on:submit.prevent="saveEmployee">
        <div class="space-y-4 rounded-md shadow-sm">
            <div>
                <img :src="employee.img" style="width: 150px;" />
                  <div>
                <label for="img" class="block text-sm font-medium text-gray-700">Img</label>
                <div class="mt-1">
                    <input type="file" name="img" id="img"
                           class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                           @change="onFileChange" />
                </div>
            </div>             
            </div>

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <div class="mt-1">
                    <input type="text" name="name" id="name"
                           class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                           v-model="employee.name" />
                </div>
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <div class="mt-1">
                    <input type="text" name="email" id="email"
                           class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                           v-model="employee.email" />
                </div>
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <div class="mt-1">
                    <input type="text" name="description" id="description"
                           class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                           v-model="employee.description" />
                </div>
            </div>

            <div>
                <label for="position" class="block text-sm font-medium text-gray-700">Position</label>
                <div class="mt-1">
                    <input type="text" name="position" id="position"
                           class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                           v-model="employee.position" />
                </div>
            </div>
            
            <div>
                <label for="website" class="block text-sm font-medium text-gray-700">Salary</label>
                <div class="mt-1">
                    <input type="number" step="0.01" name="salary" id="salary"
                           class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                           v-model="employee.salary" />
                </div>
            </div>
        </div>

        <button type="submit"
                class="inline-flex items-center px-4 py-2 mt-2 text-xs font-semibold tracking-widest text-white uppercase bg-gray-800 rounded-md border border-transparent ring-gray-300 transition duration-150 ease-in-out hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring disabled:opacity-25">
            Save
        </button>
    </form>
</template>

<script>
import useEmployee from '../composables/employee'
import { onMounted } from 'vue'
import { ref } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";

export default {
     props : {
          id : {
               require : true,
               type : String
          }
     },
     
     setup(props) {
     
     const employee = ref({
          'id' : '',
          'img' : '', 
          'name' : '',
          'email' : '',
          'description' : '',
          'position' : '',
          'salary' : ''
     })
        const errors = ref("")
        const router = useRouter()
       
        const getEmployee = async (id) => {
            let response = await axios.get(`/api/employees/${id}`)
            employee.value = response.data.data;
        }

        onMounted(getEmployee(props.id))

        const saveEmployee = async () => {
            await updateEmployee(props.id)
        }

        const updateEmployee = async (id) => {
                try {
                    const formdata = new FormData();
                   formdata.append('img',employee.value.img)
                   formdata.append('name',employee.value.name)
                   formdata.append('email',employee.value.email)
                   formdata.append('description',employee.value.description)
                   formdata.append('position',employee.value.position)
                   formdata.append('salary',employee.value.salary)
                   formdata.append('_method','patch')
                   let config = 
                   { headers: { 
                    'Content-Type': "multipart/form-data; charset=utf-8; boundary=" + Math.random().toString().substr(2),
                   'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    } }
                    await axios.post(`/api/employees/${id}`,formdata,config)
                    await router.push({ name : 'employee.index' })
                } catch (error) {
                    if(error.response.status === 422) {
                    errors.value = error.response.data.errors;
               }
                }
        }
          

     const onFileChange = async (e) => {
          employee.value.img = e.target.files[0]
     }           

          return {
               saveEmployee,
               employee,
               onFileChange,
               errors,
               router,
               updateEmployee,
          }
     }
}
</script>