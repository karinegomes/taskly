import { defineStore } from 'pinia';
import { DateValue } from 'reka-ui';

interface TasksFilter {
  status: string|null;
  priority: string|null;
  from_date: DateValue|null;
  to_date: DateValue|null;
}


export const useTasksStore = defineStore('tasks', {
  state: () => {
    return {
      tasks: [] as object[],
      task: null as object | null,
      meta: null as object | null,
      sort: [] as object[],
      filter: {
        status: null,
        priority: null,
        from_date: null,
        to_date: null
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
    async fetchTask(id: number) {
      try {
        const response = await axios.get(route("api.tasks.show", id));

        if (response.status === 200) {
          this.task = response.data.data;
        }
      } catch (error) {
        // TODO
      }
    },
    async deleteTask(id: number) {
      try {
        const response = await axios.delete(route("api.tasks.destroy", id));

        if (response.status === 200) {
          // this.task = response.data.data;
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
