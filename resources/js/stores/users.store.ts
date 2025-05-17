import { defineStore } from 'pinia';

export const useUsersStore = defineStore('users', {
  state: () => {
    return {
      users: [] as object[]
    }
  },
  actions: {
    async fetchUsers() {
      try {
        const response = await axios.get(route("api.users.index"));

        if (response.status === 200) {
          this.users = response.data.data;
        }
      } catch (error) {
        //
      }
    }
  }
})
