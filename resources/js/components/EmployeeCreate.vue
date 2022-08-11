<template>

     <!-- <div v-if="errors">
        <div v-for="(v,k) in errors" :key="k">
            <p v-for="error in v" :key="error" class="text-sm alert alert-danger">
                {{ error }}
            </p>
        </div>
    </div> -->

     <div v-if="success">
          <p v-show="success" class="alert alert-success">Əməliyyat Uğurlu Oldu</p>
     </div>

    <form class="space-y-6" @submit.prevent="saveEmployee">
        <div class="space-y-4 rounded-md shadow-sm">
             <div>
                <label for="img" class="block text-sm font-medium text-gray-700">Img</label>
                <div class="mt-1">
                    <input type="file" name="img" id="img"
                           class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                           @change="onFileChange" />
                </div>
                    <div v-if="errors && errors.img" class="bg-red">
                            <small style="color:red">{{ errors.img[0] }}</small>
                    </div>  
            </div>

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <div class="mt-1">
                    <input type="text" name="name" id="name"
                           class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                           v-model="form.name" />
                </div>
                    <div v-if="errors && errors.name" class="bg-red">
                            <small style="color:red">{{ errors.name[0] }}</small>
                    </div> 
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <div class="mt-1">
                    <input type="text" name="email" id="email"
                           class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                           v-model="form.email" />
                </div>
                    <div v-if="errors && errors.email" class="bg-red">
                            <small style="color:red">{{ errors.email[0] }}</small>
                    </div> 
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <div class="mt-1">
                    <input type="text" name="description" id="description"
                           class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                           v-model="form.description" />
                </div>
                    <div v-if="errors && errors.description" class="bg-red">
                            <small style="color:red">{{ errors.description[0] }}</small>
                    </div> 
            </div>

            <div>
                <label for="position" class="block text-sm font-medium text-gray-700">Position</label>
                <div class="mt-1">
                    <input type="text" name="position" id="position"
                           class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                           v-model="form.position" />
                </div>
                    <div v-if="errors && errors.position" class="bg-red">
                            <small style="color:red">{{ errors.position[0] }}</small>
                    </div> 
            </div>
            
            <div>
                <label for="website" class="block text-sm font-medium text-gray-700">Salary</label>
                <div class="mt-1">
                    <input type="number" step="0.01" name="salary" id="salary"
                           class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                           v-model="form.salary" />
                </div>
                    <div v-if="errors && errors.salary" class="bg-red">
                            <small style="color:red">{{ errors.salary[0] }}</small>
                    </div> 
            </div>
        </div>
        <button type="submit"
                class="inline-flex items-center px-4 py-2 mt-2 text-xs font-semibold tracking-widest text-white uppercase bg-gray-800 rounded-md border border-transparent ring-gray-300 transition duration-150 ease-in-out hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring disabled:opacity-25">
            Create
        </button>
    </form>
</template>

<script>
import { ref } from 'vue'
import useEmployee from '../composables/employee'
import "bootstrap/dist/css/bootstrap.min.css"

export default {
     setup() {
          
        const form = ref({
            'img' : '', 
            'name' : '',
            'email' : '',
            'description' : '',
            'position' : '',
            'salary' : ''
        })

        const errors = ref("")
        const success = ref("")

        const saveEmployee = async () => {
          errors.value = ""
          success.value = false
          try {
               const formdata = new FormData();
               formdata.append('img',form.value.img)
               formdata.append('name',form.value.name)
               formdata.append('email',form.value.email)
               formdata.append('description',form.value.description)
               formdata.append('position',form.value.position)
               formdata.append('salary',form.value.salary)
               let config = 
               { headers: { 
                'Content-Type': "multipart/form-data; charset=utf-8; boundary=" + Math.random().toString().substr(2),
               'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                } }
               await axios.post("/api/employees", formdata, config)
               success.value = true
               form.value.img = ''
               form.value.name = ''
               form.value.email = ''
               form.value.description = ''
               form.value.position = ''
               form.value.salary = ''
          } catch (error) {
               if(error.response.status === 422) {
                    errors.value = error.response.data.errors;
               }
          }
     }

     const onFileChange = async (e) => {
          form.value.img = e.target.files[0]
     }


      return {
          form,
          saveEmployee,
          onFileChange,
          errors,
          success
      }
     }
}
</script>