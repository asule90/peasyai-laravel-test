<template>
  <Layout>
    <Head title="Report" />
    <h1>Peasy.ai</h1>
    <h3>Report</h3>

    <v-card>
      <v-card-text>
        <highcharts 
          :options="dailyChart"
        />
      </v-card-text>
    </v-card>
  </Layout>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import Layout from '@/Layout.vue'
import { Head } from '@inertiajs/vue3'

const dailyChart = ref({
  credits: {
    enabled: false
  },
  chart: {
    // height: 350,
    type: 'line'
  },
  title: {
    text: 'Daily Records'
  },
  xAxis: {
    categories: []
  },
  plotOptions: {
    line: {
      dataLabels: {
        enabled: true
      }
    }
  },
  series: [],
})

function initChart(data) {

  const maleCountSeries =  {
    name: 'Male Count',
    data: [ ]
  }
  const maleAgeAvg =  {
    name: 'Male Age Avg',
    data: [ ]
  }
  const femaleCountSeries =  {
    name: 'Female Count',
    data: [ ]
  }
  const femaleAgeAvg =  {
    name: 'Female Age Avg',
    data: [ ]
  }

  for(let idx in data) {
    dailyChart.value.xAxis.categories.push(data[idx]['date'])

    maleCountSeries.data.push(data[idx]['male_count'])
    femaleCountSeries.data.push(data[idx]['female_count'])

    maleAgeAvg.data.push(parseFloat(data[idx]['male_avg_age']))
    femaleAgeAvg.data.push(parseFloat(data[idx]['female_avg_age']))
  }

  dailyChart.value.series.push(maleCountSeries)
  dailyChart.value.series.push(femaleCountSeries)
  dailyChart.value.series.push(maleAgeAvg)
  dailyChart.value.series.push(femaleAgeAvg)
}

function fetchDaily() {

  window.axios.get('/api/report/daily')
    .then((resp) => {
      initChart(resp.data.data)
    })
    .catch((err) => {
      if (err.response.data.message) {
        alert(err.response.data.message)
      } else {
        alert(err.message)
      }
    })
}

onMounted(() => {
  fetchDaily()
})

</script>
