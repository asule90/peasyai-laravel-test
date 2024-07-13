<template>
  <Layout>
    <Head title="Welcome" />
    <h1>Peasy.ai</h1>

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
      </template>

      <v-data-table 
        :items="data"
        :headers="headers"
        :search="search"
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
import { ref } from 'vue'
import Layout from '@/Layout.vue'
import { Head } from '@inertiajs/vue3'

defineProps({ 
  data: Array ,
})

const search = ref('')

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
  
  window.axios.delete('/api/' + uuid)
    .then((resp) => {
      window.location.reload()
    }).catch((err) => {
      alert(err.message)
    })
}

</script>
