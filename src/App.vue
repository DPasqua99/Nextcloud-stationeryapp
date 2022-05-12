<template>
	<Content :class="{'icon-loading': loading}" app-name="stationeryapp">
		<AppNavigation
			title="Filtri">
			<FilterSection />
			<AppNavigationSpacer />
			<div class="bottom">
				<MaterialSection
					:materials="materials"
					@new-item="addMaterial" />
			</div>
		</AppNavigation>
		<AppContent>
			<Table
				:actions="actions"
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
import Table from './Components/Table/Table.vue'
import MaterialSection from './Components/Sidebar/MaterialSection.vue'
import FilterSection from './Components/Sidebar/FilterSection.vue'
import ModalContent from './Components/Modal/ModalContent.vue'
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
		Table,
		MaterialSection,
		FilterSection,
		ModalContent,
	},
	data() {
		return {
			loading: false,
			currentNoteId: null,
			currentActionId: null,
			updating: false,
			newName: null,
			newQuantity: null,
			newMat: null,
			form: null,
			currentAction: null,
			actions: [],
			materials: [],
		}
	},
	computed: {
	},
	/**
	 * Fetch list of actions when the component is loaded
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
				this.removeQuantity(action.quantity, action.material)
			} catch (e) {
				console.error(e)
				showError(t('stationeryapp', 'Could not create the action'))
			}
			this.updating = false
		},
		/**
		 * Delete an action, remove it from the frontend and show a hint
		 *
		 * @param {number} id id of the action object
		 */
		async deleteAction(id) {
			alert(id)
			let action = null
			for (let i = 0, len = this.actions.length; i < len; i++) {
				if (id === this.actions[i].id) {
					action = this.actions[i]
				}
			}
			try {
				await axios.delete(generateUrl(`/apps/stationeryapp/deleteAction/${action.id}`))
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
		 * Add a new material to the materials array
		 *
		 * @param {string} name the name of the material to add
		 */
		addMaterial(name) {
			const matName = name[0].toUpperCase() + name.slice(1)
			const mat = {
				id: this.nextMaterialId,
				name: matName,
				quantity: 20,
			}
			this.nextMaterialId++
			this.materials.push(mat)
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
