import { defineStore } from 'pinia';

export const useTasksStore = defineStore('tasks', {
  state: () => {
    return {
      tasks: [] as object[],
      meta: null as object
    }
  },
  actions: {
    async fetch(page = 1, perPage = 10) {
      try {
        const response = await axios.get(route("api.tasks.index"), {
          params: {
            page: page,
            per_page: perPage
          }
        });

        if (response.status === 200) {
          this.tasks = response.data.data;
          this.meta = response.data.meta;
        }
      } catch (error) {
        // TODO
      }
    }
  }
})
