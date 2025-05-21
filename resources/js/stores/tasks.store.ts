import { defineStore } from 'pinia';

interface TasksFilter {
  status: string|null;
  priority: string|null;
}


export const useTasksStore = defineStore('tasks', {
  state: () => {
    return {
      tasks: [] as object[],
      meta: null as object | null,
      sort: [] as object[],
      filter: {
        status: null,
        priority: null
      } as TasksFilter
    }
  },
  actions: {
    async fetch(page: number = 1, perPage: number = 10) {
      try {
        const response = await axios.get(route("api.tasks.index"), {
          params: {
            page: page,
            per_page: perPage,
            sort: this.sort,
            filter: this.filter
          }
        });

        if (response.status === 200) {
          this.tasks = response.data.data;
          this.meta = response.data.meta;
        }
      } catch (error) {
        // TODO
      }
    },
    resetFilters() {
      this.filter = {
        status: null,
        priority: null
      }
    }
  }
})
