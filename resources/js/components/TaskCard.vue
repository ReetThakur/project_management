<template>
  <div
    class="task bg-white rounded shadow p-3 cursor-move"
    :class="{ 'border-l-4': task.color }"
    :style="task.color ? `border-left-color: ${task.color}` : ''"
  >
    <div class="flex justify-between items-start">
      <h4 class="font-medium">{{ task.title }}</h4>
      <div class="flex space-x-2">
        <span v-if="task.due_date" class="text-sm text-gray-500">
          {{ formatDate(task.due_date) }}
        </span>
        <img
          v-if="task.assignee"
          :src="task.assignee.avatar"
          :alt="task.assignee.name"
          class="w-6 h-6 rounded-full"
        />
      </div>
    </div>
    
    <p class="text-sm text-gray-600 mt-2">{{ task.description }}</p>
    
    <!-- Labels -->
    <div class="flex flex-wrap gap-1 mt-2">
      <span
        v-for="label in task.labels"
        :key="label.id"
        class="px-2 py-1 text-xs rounded-full"
        :style="{ backgroundColor: label.color + '20', color: label.color }"
      >
        {{ label.name }}
      </span>
    </div>
    
    <!-- Checklists -->
    <div v-if="task.checklists?.length" class="mt-3 space-y-2">
      <div
        v-for="checklist in task.checklists"
        :key="checklist.id"
        class="checklist"
      >
        <div class="flex items-center justify-between">
          <h5 class="text-sm font-medium">{{ checklist.title }}</h5>
          <span class="text-xs text-gray-500">
            {{ getChecklistProgress(checklist) }}
          </span>
        </div>
        
        <div class="mt-1 space-y-1">
          <div
            v-for="item in checklist.items"
            :key="item.id"
            class="flex items-center space-x-2"
          >
            <input
              type="checkbox"
              :checked="item.is_completed"
              @change="toggleChecklistItem(item)"
              class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
            />
            <span
              class="text-sm"
              :class="{ 'line-through text-gray-400': item.is_completed }"
            >
              {{ item.content }}
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { defineComponent } from 'vue'
import axios from 'axios'

export default defineComponent({
  props: {
    task: {
      type: Object,
      required: true
    }
  },

  setup(props) {
    const formatDate = (date) => {
      return new Date(date).toLocaleDateString()
    }

    const getChecklistProgress = (checklist) => {
      const total = checklist.items.length
      const completed = checklist.items.filter(item => item.is_completed).length
      return `${completed}/${total}`
    }

    const toggleChecklistItem = async (item) => {
      try {
        await axios.put(`/api/checklist-items/${item.id}`, {
          is_completed: !item.is_completed
        })
        item.is_completed = !item.is_completed
      } catch (error) {
        console.error('Error toggling checklist item:', error)
      }
    }

    return {
      formatDate,
      getChecklistProgress,
      toggleChecklistItem
    }
  }
})
</script>

<style scoped>
.checklist {
  background-color: #f8fafc;
  border-radius: 0.375rem;
  padding: 0.5rem;
}
</style> 