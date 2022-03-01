<template>
	<div>
		<button class="fixed-right-bottom" @click="showModal">
			Show Modal
		</button>
		<Modal v-if="modal"
			size="large"
			@close="closeModal">
			<div class="modal__content">
				<form
					id="add-form"
					role="form"
					method="POST"
					action="">
					<div class="modal-body">
						<div class="form-group">
							<label class="control-label title">Nome</label>
							<div>
								<input id="form-name"
									v-model="actionName"
									type="text"
									class="form-control input-lg"
									name="Nome"
									placeholder="Inserisci un nome..."
									required>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label title">Materiale</label>
							<div>
								<select
									id="form-material"
									v-model="mat"
									class="form-select"
									aria-label="Default select example">
									<option v-for="material in materials"
										:key="material.id"
										:value="material.name">
										{{ material.name }}
									</option>
								</select>
							</div>
						</div>

						<div class="form-group">
							<div>
								<div>
									<label for="customRange2" class="form-label title">Quantita</label>
								</div>
								<div>
									<input id="form-quantity"
										v-model="quantity"
										type="range"
										min="1"
										max="10">
								</div>
								<div>
									<p>Selezionato: {{ quantity }}</p>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<div class="form-group">
							<div>
								<button class="btn btn-primary" @click="onAddAction()">
									Aggiungi
								</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</Modal>
	</div>
</template>

<script>
import Modal from '@nextcloud/vue/dist/Components/Modal'
import moment from 'moment'

export default {
	name: 'ModalContent',
	components: {
		Modal,
	},
	props: {
		materials: {
			type: Array,
			default: null,
		},
	},
	data() {
		return {
			modal: false,
			quantity: null,
			actionName: null,
			mat: [],
		}
	},
	methods: {
		showModal() {
			this.modal = true
		},
		closeModal() {
			this.modal = false
		},
		onAddAction() {
			const action = {
				id: -1,
				actionName: this.actionName,
				mat: this.mat,
				quantity: this.quantity,
				date: moment().format('YYYY-MM-DD hh:mm'),
			}
			this.$emit('clicked', action)
			this.closeModal()
		},
	},
}
</script>

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

	.title{
		font-size: 16px;
		font-weight: bold;
		margin-bottom: 10px;
	}
</style>
