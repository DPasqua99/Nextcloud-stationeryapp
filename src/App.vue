<template>
	<Content :class="{'icon-loading': loading}" app-name="Magazzino">
		<AppNavigation
			title="Filtri">
			<FilterSection
				@filterAll="filterAll"
				@filterToday="filterToday"
				@filterLastWeek="filterLastWeek"
				@filterLastMonth="filterLastMonth" />
			<AppNavigationSpacer />
			<MaterialSection
				:materials="materials"
				@new-item="addMaterial"
				@remove-material="removeMaterial"
				@set-quantity="setMaterialQuantity" />
		</AppNavigation>
		<AppContent>
			<TitleTable
				:title="title" />
			<TableContent
				v-for="action in actions"
				:key="action.id"
				:action-id="action.id"
				:action-name="action.name"
				:mat="action.material"
				:quantity="action.quantity"
				:date="action.date"
				@delete="deleteAction" />
			<ModalContent
				:materials="materials"
				@submit="addAction" />
		</AppContent>
	</Content>
</template>

<script>
import Content from '@nextcloud/vue/dist/Components/Content'
import AppContent from '@nextcloud/vue/dist/Components/AppContent'
import AppNavigation from '@nextcloud/vue/dist/Components/AppNavigation'
import AppNavigationSpacer from '@nextcloud/vue/dist/Components/AppNavigationSpacer'
import TableContent from './Components/Table/TableContent.vue'
import MaterialSection from './Components/Sidebar/MaterialSection.vue'
import FilterSection from './Components/Sidebar/FilterSection.vue'
import ModalContent from './Components/Modal/ModalContent.vue'
import TitleTable from './Components/Table/TitleTable.vue'
import moment from 'moment'

import '@nextcloud/dialogs/styles/toast.scss'
import { generateUrl } from '@nextcloud/router'
import { showError, showSuccess } from '@nextcloud/dialogs'
import axios from '@nextcloud/axios'

export default {
	name: 'App',
	components: {
		Content,
		AppContent,
		AppNavigation,
		AppNavigationSpacer,
		TableContent,
		MaterialSection,
		FilterSection,
		ModalContent,
		TitleTable,
	},
	data() {
		return {
			loading: false,
			currentMaterialId: null,
			currentActionId: null,
			updating: false,
			newName: null,
			newQuantity: null,
			newMat: null,
			form: null,
			currentAction: null,
			currentMaterial: null,
			actions: [],
			materials: [],
			title: 'Tutto',
		}
	},
	computed: {
	},
	/**
	 * Fetch list of actions and materials when the component is loaded
	 */
	async mounted() {
		try {
			const responseActions = await axios.get(generateUrl('/apps/stationeryapp/actions'))
			this.actions = responseActions.data
			const responseMaterials = await axios.get(generateUrl('/apps/stationeryapp/materials'))
			this.materials = responseMaterials.data
		} catch (e) {
			console.error(e)
			showError(t('stationeryapp', 'Could not fetch actions'))
		}
		this.loading = false
	},
	methods: {
		log() {
			console.debug(arguments)
		},
		/**
		 * Create a new action
		 * The action is not yet saved, therefore an id of -1 is used until it
		 * has been persisted in the backend
		 *
		 * @param {object} form the parameters from the form
		 */
		addAction(form) {
			const tempAction = {
				id: -1,
				name: form.actionName,
				material: form.actionMat,
				quantity: Number(form.actionQuantity),
				date: moment().format('YYYY-MM-DD hh:mm'),
			}
			this.currentAction = tempAction
			this.currentActionId = tempAction.id

			this.removeQuantity(tempAction.quantity, tempAction.material)

			this.saveAction()
			this.actions.push(tempAction)
		},
		/**
		 * Action tiggered when clicking the save button
		 * create a new action or save
		 */
		saveAction() {
			if (this.currentActionId === -1) {
				this.createAction(this.currentAction)
			}
		},
		/**
		 * Action tiggered when clicking the save button
		 * save a new material on the database
		 */
		saveMaterial() {
			if (this.currentMaterialId === -1) {
				this.createMaterial(this.currentMaterial)
			}
		},
		/**
		 * Create a new action by sending the information to the server
		 *
		 * @param {object} action Action object
		 */
		async createAction(action) {
			this.updating = true
			try {
				const response = await axios.post(generateUrl('/apps/stationeryapp/insertAction'), action)
				const index = this.actions.findIndex((match) => match.id === this.currentActionId)
				this.$set(this.actions, index, response.data)
				this.currentActionId = response.data.id
			} catch (e) {
				console.error(e)
				showError(t('stationeryapp', 'Could not create the action'))
			}
			this.updating = false
		},
		/**
		 * Create a new material by sending the information to the server
		 *
		 * @param {object} material Material object
		 */
		async createMaterial(material) {
			this.updating = true
			try {
				const response = await axios.post(generateUrl('/apps/stationeryapp/insertMaterial'), material)
				const index = this.materials.findIndex((match) => match.id === this.currentMaterialId)
				this.$set(this.materials, index, response.data)
				this.currentMaterialId = response.data.id
				showSuccess(t('stationeryapp', 'Material Created'))
			} catch (e) {
				console.error(e)
				showError(t('stationeryapp', 'Could not set the material'))
			}
			this.updating = false
		},
		/**
		 * Delete an action, remove it from the frontend and show a hint
		 *
		 * @param {number} id id of the action object
		 */
		async deleteAction(id) {
			let action = null
			for (let i = 0, len = this.actions.length; i < len; i++) {
				if (id === this.actions[i].id) {
					action = this.actions[i]
				}
			}
			try {
				await axios.delete(generateUrl(`/apps/stationeryapp/deleteAction/${action.id}`))
				this.readdQuantity(action.material, action.quantity)
				this.actions.splice(this.actions.indexOf(action), 1)
				if (this.currentActionId === action.id) {
					this.currentActionId = null
				}
				showSuccess(t('stationeryapp', 'Action deleted'))
			} catch (e) {
				console.error(e)
				showError(t('stationeryapp', 'Could not delete the action'))
			}
		},
		/**
		 * Delete a material, remove it from the frontend and show a hint
		 *
		 * @param {number} id id of the material object
		 */
		async removeMaterial(id) {
			try {
				await axios.delete(generateUrl(`/apps/stationeryapp/deleteMaterial/${id}`))
				this.materials.splice(this.materials.indexOf(id), 1)
				if (this.currentMaterialId === id) {
					this.currentActionId = null
				}
				showSuccess(t('stationeryapp', 'Material deleted'))
			} catch (e) {
				console.error(e)
				showError(t('stationeryapp', 'Could not delete the material'))
			}
		},
		/**
		 * Delete an action, remove it from the frontend and show a hint
		 *
		 * @param {object} newMaterial the material with the new quantity
		 */
		setMaterialQuantity(newMaterial) {
			for (let i = 0, len = this.materials.length; i < len; i++) {
				if (newMaterial.id === this.materials[i].id) {
					newMaterial.name = this.materials[i].name
					this.materials[i].quantity = newMaterial.quantity
					this.updateMaterial(newMaterial)
				}
			}
		},
		/**
		 * Add a new material to the materials array
		 *
		 * @param {string} name the name of the material to add
		 */
		addMaterial(name) {
			const matName = name[0].toUpperCase() + name.slice(1)
			const tempMaterial = {
				id: -1,
				name: matName,
				quantity: 20,
			}
			this.currentMaterialId = tempMaterial.id
			this.currentMaterial = tempMaterial

			this.saveMaterial()

			this.materials.push(tempMaterial)
		},
		/**
		 * Remove a quantity
		 *
		 * @param {number} quantityToRemove the number of material to remove
		 * @param {string} materialFromRemove the material to remove
		 */
		removeQuantity(quantityToRemove, materialFromRemove) {
			for (let i = 0, len = this.materials.length; i < len; i++) {
				 if (materialFromRemove.toLowerCase() === this.materials[i].name.toLowerCase()) {
					 if (this.controlMagQuantity(this.materials[i], quantityToRemove)) {
						this.materials[i].quantity = this.materials[i].quantity - quantityToRemove
						this.updateMaterial(this.materials[i])
					 }
				 }
			}
		},
		/**
		 * Check if the quantity in stock is sufficient
		 *
		 * @param {object} material the material to remove
		 * @param {number} quantityToRemove the quantity to remove
		 */
		controlMagQuantity(material, quantityToRemove) {
			if ((parseInt(material.quantity) - parseInt(quantityToRemove)) < 0) {
				showError(t('stationeryapp', 'Could not create action: insufficient material'))
				return false
			} else {
				return true
			}
		},
		/**
		 * Update an existing material on the server
		 *
		 * @param {object} material Material object
		 */
		async updateMaterial(material) {
			this.updating = true
			try {
				await axios.put(generateUrl(`/apps/stationeryapp/updateMaterial/${material.id}`), material)
			} catch (e) {
				console.error(e)
				showError(t('stationeryapp', 'Could not update the material'))
			}
			this.updating = false
		},
		/**
		 * Check if the quantity in stock is sufficient
		 *
		 * @param {string} materialToReadd the material to remove
		 * @param {number} quantityToReadd the quantity to remove
		 */
		readdQuantity(materialToReadd, quantityToReadd) {
			for (let i = 0, len = this.materials.length; i < len; i++) {
				 if (materialToReadd.toLowerCase() === this.materials[i].name.toLowerCase()) {
					this.materials[i].quantity = (parseInt(this.materials[i].quantity) + parseInt(quantityToReadd))
					this.updateMaterial(this.materials[i])
				 }
			}
		},
		filterAll() {
			this.title = 'Tutti'
		},
		filterToday() {
			this.title = 'Oggi'
		},
		filterLastWeek() {
			this.title = 'Ultima Settimana'
		},
		filterLastMonth() {
			this.title = 'Ultimo Mese'
		},
	},
}
</script>

<style src="@vueform/slider/themes/default.css"></style>

<style scoped>
	.modal__content {
		margin: 50px;
		text-align: center;
	}

	.fixed-right-bottom {
		position:absolute;
		right:0;
		bottom: 0;
		z-index: 1030;
		margin: 0 1.5rem 1.5rem 0;
		border-radius:50%;
	}

	.bottom{
		position: absolute;
		bottom: 0;
	}

	.app-content{
		background-color: var(--color-background-dark) !important;
	}

</style>
