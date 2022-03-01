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
				@clicked="deleteAction(action)" />
			<ModalContent
				:materials="materials"
				@clicked="createAction" />
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
			updating: false,
			actions: [
				{
					id: 1,
					actionName: 'Davide',
					mat: 'Penne',
					quantity: 3,
					date: moment().format('DD/MM/YY hh:mm'),
				},
				{
					id: 2,
					actionName: 'Alberto',
					mat: 'Penne',
					quantity: 1,
					date: moment().format('DD/MM/YY hh:mm'),
				},
			],
			currentActionId: 3,
			materials: [
				{
					id: 1,
					name: 'Penne',
					quantity: 20,
				},
				{
					id: 2,
					name: 'Raccoglitori',
					quantity: 20,
				},
				{
					id: 3,
					name: 'Matite',
					quantity: 20,
				},
			],
			nextMaterialId: 4,
		}
	},
	computed: {
	},
	/**
	 * Fetch list of actions when the component is loaded
	 */
	async mounted() {
		try {
			const response = await axios.get(generateUrl('/apps/stationeryapp/actions'))
			this.actions = response.data
		} catch (e) {
			console.error(e)
			showError(t('stationeryapp', 'Could not fetch notes'))
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
		 */
		addAction(newName, newQuantity, newMat) {
			if (this.currentNoteId !== -1) {
				this.currentNoteId = -1
				const action = {
					id: -1,
					actionName: newName,
					mat: newMat,
					quantity: newQuantity,
					date: moment().format('DD/MM/YY hh:mm'),
				}
				this.actions.push(action)
			}
		},
		/**
		 * Action tiggered when clicking the save button
		 * create a new action or save
		 */
		saveAction() {
			if (this.currentActionId === -1) {
				this.createAction(this.currentNote)
			}
		},
		/**
		 * Create a new action by sending the information to the server
		 * @param {Object} action Action object
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
		 * Delete an action, remove it from the frontend and show a hint
		 * @param {Object} action Action object
		 */
		async deleteAction(action) {
			try {
				await axios.delete(generateUrl(`/apps/stationeryapp/actions/${action.id}`))
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
		addMaterial(value) {
			const matName = value[0].toUpperCase() + value.slice(1)
			const mat = {
				id: this.nextMaterialId,
				name: matName,
				quantity: 20,
			}
			this.nextMaterialId++
			this.materials.push(mat)
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
