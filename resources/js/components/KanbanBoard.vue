<template>
  <div class="kanban-board">
    <div class="flex space-x-4 overflow-x-auto p-4">
      <draggable
        v-model="columns"
        group="columns"
        item-key="id"
        class="flex space-x-4"
        @end="onColumnDragEnd"
      >
        <template #item="{ element: column }">
          <div class="column bg-gray-100 rounded-lg p-4 w-80 flex-shrink-0">
            <div class="flex justify-between items-center mb-4">
              <h3 class="text-lg font-semibold">{{ column.title }}</h3>
              <button
                @click="addTask(column.id)"
                class="text-gray-500 hover:text-gray-700"
              >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
              </button>
            </div>
            
            <draggable
              v-model="column.tasks"
              group="tasks"
              item-key="id"
              class="space-y-2"
              @end="onTaskDragEnd"
            >
              <template #item="{ element: task }">
                <TaskCard :task="task" />
              </template>
            </draggable>
          </div>
        </template>
      </draggable>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue'
import draggable from 'vuedraggable'
import axios from 'axios'
import TaskCard from './TaskCard.vue'

export default {
  components: {
    draggable,
    TaskCard
  },
  
  props: {
    projectId: {
      type: Number,
      required: true
    }
  },

  setup(props) {
    const columns = ref([])

    const fetchColumns = async () => {
      try {
        const response = await axios.get(`/api/projects/${props.projectId}/columns`)
        columns.value = response.data
      } catch (error) {
        console.error('Error fetching columns:', error)
      }
    }

    const onColumnDragEnd = async (evt) => {
      try {
        await axios.put(`/api/projects/${props.projectId}/columns/reorder`, {
          columns: columns.value.map((col, index) => ({
            id: col.id,
            order: index
          }))
        })
      } catch (error) {
        console.error('Error reordering columns:', error)
      }
    }

    const onTaskDragEnd = async (evt) => {
      const { from, to, item } = evt
      const taskId = item.__draggable_component__.element.id
      const newColumnId = to.__draggable_component__.element.id
      
      try {
        await axios.put(`/api/tasks/${taskId}/move`, {
          column_id: newColumnId,
          order: evt.newIndex
        })
      } catch (error) {
        console.error('Error moving task:', error)
      }
    }

    const addTask = (columnId) => {
      // Implement task creation modal/form
    }

    onMounted(() => {
      fetchColumns()
    })

    return {
      columns,
      onColumnDragEnd,
      onTaskDragEnd,
      addTask
    }
  }
}
</script>

<style scoped>
.kanban-board {
  min-height: calc(100vh - 4rem);
  background-color: #f8fafc;
}

.column {
  min-height: 100px;
  max-height: calc(100vh - 8rem);
  overflow-y: auto;
}

.task {
  transition: all 0.2s ease;
}

.task:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}
</style> 