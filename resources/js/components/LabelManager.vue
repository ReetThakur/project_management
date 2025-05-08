<template>
  <div class="label-manager">
    <div class="flex items-center justify-between mb-4">
      <h3 class="text-lg font-semibold">Labels</h3>
      <button
        @click="showCreateModal = true"
        class="px-3 py-1 text-sm bg-blue-600 text-white rounded hover:bg-blue-700"
      >
        Add Label
      </button>
    </div>

    <div class="space-y-2">
      <div
        v-for="label in labels"
        :key="label.id"
        class="flex items-center justify-between p-2 bg-gray-50 rounded"
      >
        <div class="flex items-center space-x-2">
          <span
            class="w-4 h-4 rounded-full"
            :style="{ backgroundColor: label.color }"
          ></span>
          <span>{{ label.name }}</span>
        </div>
        <div class="flex space-x-2">
          <button
            @click="editLabel(label)"
            class="text-gray-500 hover:text-gray-700"
          >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
          </button>
          <button
            @click="deleteLabel(label)"
            class="text-red-500 hover:text-red-700"
          >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
          </button>
        </div>
      </div>
    </div>

    <!-- Create/Edit Label Modal -->
    <div v-if="showCreateModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
      <div class="bg-white rounded-lg p-6 w-96">
        <h3 class="text-lg font-semibold mb-4">
          {{ editingLabel ? 'Edit Label' : 'Create Label' }}
        </h3>
        
        <form @submit.prevent="saveLabel" class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700">Name</label>
            <input
              v-model="labelForm.name"
              type="text"
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
              required
            />
          </div>
          
          <div>
            <label class="block text-sm font-medium text-gray-700">Color</label>
            <input
              v-model="labelForm.color"
              type="color"
              class="mt-1 block w-full h-10 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
              required
            />
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
              {{ editingLabel ? 'Update' : 'Create' }}
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
    projectId: {
      type: Number,
      required: true
    }
  },

  setup(props) {
    const labels = ref([])
    const showCreateModal = ref(false)
    const editingLabel = ref(null)
    const labelForm = ref({
      name: '',
      color: '#000000'
    })

    const fetchLabels = async () => {
      try {
        const response = await axios.get(`/api/projects/${props.projectId}/labels`)
        labels.value = response.data
      } catch (error) {
        console.error('Error fetching labels:', error)
      }
    }

    const saveLabel = async () => {
      try {
        if (editingLabel.value) {
          await axios.put(`/api/labels/${editingLabel.value.id}`, labelForm.value)
        } else {
          await axios.post(`/api/projects/${props.projectId}/labels`, labelForm.value)
        }
        await fetchLabels()
        showCreateModal.value = false
        resetForm()
      } catch (error) {
        console.error('Error saving label:', error)
      }
    }

    const editLabel = (label) => {
      editingLabel.value = label
      labelForm.value = { ...label }
      showCreateModal.value = true
    }

    const deleteLabel = async (label) => {
      if (!confirm('Are you sure you want to delete this label?')) return

      try {
        await axios.delete(`/api/labels/${label.id}`)
        await fetchLabels()
      } catch (error) {
        console.error('Error deleting label:', error)
      }
    }

    const resetForm = () => {
      editingLabel.value = null
      labelForm.value = {
        name: '',
        color: '#000000'
      }
    }

    onMounted(() => {
      fetchLabels()
    })

    return {
      labels,
      showCreateModal,
      editingLabel,
      labelForm,
      saveLabel,
      editLabel,
      deleteLabel
    }
  }
}
</script> 