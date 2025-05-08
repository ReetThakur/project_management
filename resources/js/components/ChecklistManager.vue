<template>
  <div class="checklist-manager">
    <div class="flex items-center justify-between mb-4">
      <h3 class="text-lg font-semibold">Checklists</h3>
      <button
        @click="showCreateModal = true"
        class="px-3 py-1 text-sm bg-blue-600 text-white rounded hover:bg-blue-700"
      >
        Add Checklist
      </button>
    </div>

    <div class="space-y-4">
      <div
        v-for="checklist in checklists"
        :key="checklist.id"
        class="bg-gray-50 rounded p-4"
      >
        <div class="flex items-center justify-between mb-2">
          <h4 class="font-medium">{{ checklist.title }}</h4>
          <div class="flex space-x-2">
            <button
              @click="editChecklist(checklist)"
              class="text-gray-500 hover:text-gray-700"
            >
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
              </svg>
            </button>
            <button
              @click="deleteChecklist(checklist)"
              class="text-red-500 hover:text-red-700"
            >
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
              </svg>
            </button>
          </div>
        </div>

        <div class="space-y-2">
          <div
            v-for="item in checklist.items"
            :key="item.id"
            class="flex items-center space-x-2"
          >
            <input
              type="checkbox"
              :checked="item.is_completed"
              @change="toggleItem(item)"
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

        <div class="mt-2">
          <input
            v-model="newItems[checklist.id]"
            @keyup.enter="addItem(checklist)"
            type="text"
            placeholder="Add an item..."
            class="w-full text-sm border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
          />
        </div>
      </div>
    </div>

    <!-- Create/Edit Checklist Modal -->
    <div v-if="showCreateModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
      <div class="bg-white rounded-lg p-6 w-96">
        <h3 class="text-lg font-semibold mb-4">
          {{ editingChecklist ? 'Edit Checklist' : 'Create Checklist' }}
        </h3>
        
        <form @submit.prevent="saveChecklist" class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700">Title</label>
            <input
              v-model="checklistForm.title"
              type="text"
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
              required
            />
          </div>
          
          <div>
            <label class="block text-sm font-medium text-gray-700">Items</label>
            <div class="space-y-2">
              <div
                v-for="(item, index) in checklistForm.items"
                :key="index"
                class="flex items-center space-x-2"
              >
                <input
                  v-model="checklistForm.items[index]"
                  type="text"
                  class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                  placeholder="Item content"
                />
                <button
                  type="button"
                  @click="removeItem(index)"
                  class="text-red-500 hover:text-red-700"
                >
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                  </svg>
                </button>
              </div>
            </div>
            <button
              type="button"
              @click="addFormItem"
              class="mt-2 text-sm text-blue-600 hover:text-blue-700"
            >
              + Add Item
            </button>
          </div>
          
          <div class="flex justify-end space-x-2">
            <button
              type="button"
              @click="showCreateModal = false"
              class="px-4 py-2 text-sm text-gray-700 hover:text-gray-900"
            >
              Cancel
            </button>
            <button
              type="submit"
              class="px-4 py-2 text-sm bg-blue-600 text-white rounded hover:bg-blue-700"
            >
              {{ editingChecklist ? 'Update' : 'Create' }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue'
import axios from 'axios'

export default {
  props: {
    taskId: {
      type: Number,
      required: true
    }
  },

  setup(props) {
    const checklists = ref([])
    const showCreateModal = ref(false)
    const editingChecklist = ref(null)
    const newItems = ref({})
    const checklistForm = ref({
      title: '',
      items: ['']
    })

    const fetchChecklists = async () => {
      try {
        const response = await axios.get(`/api/tasks/${props.taskId}/checklists`)
        checklists.value = response.data
      } catch (error) {
        console.error('Error fetching checklists:', error)
      }
    }

    const saveChecklist = async () => {
      try {
        const items = checklistForm.value.items.filter(item => item.trim())
        if (editingChecklist.value) {
          await axios.put(`/api/checklists/${editingChecklist.value.id}`, {
            title: checklistForm.value.title
          })
        } else {
          await axios.post(`/api/tasks/${props.taskId}/checklists`, {
            title: checklistForm.value.title,
            items: items.map(content => ({ content }))
          })
        }
        await fetchChecklists()
        showCreateModal.value = false
        resetForm()
      } catch (error) {
        console.error('Error saving checklist:', error)
      }
    }

    const editChecklist = (checklist) => {
      editingChecklist.value = checklist
      checklistForm.value = {
        title: checklist.title,
        items: checklist.items.map(item => item.content)
      }
      showCreateModal.value = true
    }

    const deleteChecklist = async (checklist) => {
      if (!confirm('Are you sure you want to delete this checklist?')) return

      try {
        await axios.delete(`/api/checklists/${checklist.id}`)
        await fetchChecklists()
      } catch (error) {
        console.error('Error deleting checklist:', error)
      }
    }

    const toggleItem = async (item) => {
      try {
        await axios.put(`/api/checklist-items/${item.id}`, {
          is_completed: !item.is_completed
        })
        item.is_completed = !item.is_completed
      } catch (error) {
        console.error('Error toggling item:', error)
      }
    }

    const addItem = async (checklist) => {
      const content = newItems.value[checklist.id]?.trim()
      if (!content) return

      try {
        await axios.post(`/api/checklists/${checklist.id}/items`, { content })
        await fetchChecklists()
        newItems.value[checklist.id] = ''
      } catch (error) {
        console.error('Error adding item:', error)
      }
    }

    const addFormItem = () => {
      checklistForm.value.items.push('')
    }

    const removeItem = (index) => {
      checklistForm.value.items.splice(index, 1)
    }

    const resetForm = () => {
      editingChecklist.value = null
      checklistForm.value = {
        title: '',
        items: ['']
      }
    }

    onMounted(() => {
      fetchChecklists()
    })

    return {
      checklists,
      showCreateModal,
      editingChecklist,
      newItems,
      checklistForm,
      saveChecklist,
      editChecklist,
      deleteChecklist,
      toggleItem,
      addItem,
      addFormItem,
      removeItem
    }
  }
}
</script> 