<template>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="table-head">#</th>
                        <th v-for="column in columns" :key="column" class="table-head">
                            {{ column | columnHead }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="" v-if="tableData.length === 0">
                        <td class="lead text-center" :colspan="columns.length + 1">No data found.</td>
                    </tr>
                    <tr v-for="(data, key1) in tableData" :key="data.id" class="m-datatable__row" v-else>
                        <td>{{ idNumber(key1) }}</td>
                        <td v-for="(value, key) in data" :key="key">{{ value }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script type="text/ecmascript-6">
export default {
  props: {
    fetchUrl: { type: String, required: true },
    columns: { type: Array, required: true },
  },
  data() {
    return {
      tableData: []
    }
  },
  created() {
    return this.fetchData(this.fetchUrl)
  },
  methods: {
    fetchData(url) {
      axios.get(url)
        .then(data => {
          this.tableData = data.data.data
        })
    },
    /**
     * Get the id number.
     * @param key
     * */
    idNumber(key) {
      return key + 1;
    },
  },
  filters: {
    columnHead(value) {
      return value.split('_').join(' ').toUpperCase()
    }
  },
  name: 'DataTable'
}
</script>

<style scoped>
</style>