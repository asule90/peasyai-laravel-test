<template>
  <Layout>
    <Head title="Home" />
    <h1>Peasy.ai</h1>
    <h3>Home</h3>

    <v-card>
      <template v-slot:text>
        <v-text-field
          v-model="search"
          label="Search"
          prepend-inner-icon="mdi-magnify"
          variant="outlined"
          hide-details
          single-line
        ></v-text-field>

        <v-icon 
          icon="mdi-refresh" color="red"
          @click="fetchUsers();"
        />
      </template>

      <v-data-table 
        :items="data"
        :headers="headers"
        :search="search"
        :loading="loading"
      >
        <template v-slot:item="{ item }">
          <tr>
            <td>{{ item.uuid }}</td>
            <td>{{ item.full_name }}</td>
            <td>{{ item.gender }}</td>
            <td>{{ item.age }}</td>
            <td>{{ item.full_location }}</td>
            <td>{{ item.created_at }}</td>
            <td>
              <v-icon 
                icon="mdi-trash-can" color="red"
                @click="deleteUser(item.uuid);"
              />
            </td>
          </tr>
        </template>
      </v-data-table>
    </v-card>
  </Layout>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import Layout from '@/Layout.vue'
import { Head } from '@inertiajs/vue3'

const search = ref('')
let data = ref([])
let loading = ref(true)

const headers = ref([
  { title: 'ID', value: 'uuid', key: 'uuid', sortable: false },
  { title: 'Name', value: 'full_name', key: 'full_name', sortable: false },
  { title: 'Gender', value: 'gender', key: 'gender', sortable: false },
  { title: 'Age', value: 'age', key: 'age', sortable: false },
  { title: 'Location', value: 'full_location', key: 'full_location', sortable: false },
  { title: 'Created', sortable: false },
  { title: '', sortable: false },
])

function deleteUser(uuid) {
  if(!confirm('you are going to delete this data, are you sure?')){
    return false;
  }
  
  window.axios.delete('/api/users/' + uuid)
    .then((resp) => {
      fetchusers()
    }).catch((err) => {
      if (err.response.data.message) {
        alert(err.response.data.message)
      } else {
        alert(err.message)
      }
    })
}

function fetchUsers() {
  loading.value = true

  window.axios.get('/api/users')
    .then((resp) => {
      data.value = resp.data.data
    }).catch((err) => {
      if (err.response.data.message) {
        alert(err.response.data.message)
      } else {
        alert(err.message)
      }
    }).finally(() => {
      loading.value = false
    })
}

onMounted(() => {
  fetchUsers()
})

</script>
