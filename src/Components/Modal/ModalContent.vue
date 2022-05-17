<template>
	<div>
		<Button class="fixed-right-bottom" @click="showModal">
			Aggiungi Azione
		</Button>
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
									v-model="form.actionName"
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
									v-model="form.actionMat"
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
										v-model="form.actionQuantity"
										type="range"
										min="1"
										max="10">
								</div>
								<div>
									<p>Selezionato: {{ form.actionQuantity }}</p>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<div class="form-group">
							<div>
								<button class="btn btn-primary" @click="addAction(form)">
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
// import moment from 'moment'

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
	emits: {
		submit: (form) => {
			if (form.actionName && form.actionMat && form.actionQuantity) {
				return true
			} else {
				console.warn('Invalid submit event payload!')
				return false
			}
		},
	},
	data() {
		return {
			modal: false,
			form: {
				actionName: '',
				actionMat: [],
				actionQuantity: 1,
			},
			currentActionId: null,
		}
	},
	methods: {
		showModal() {
			this.modal = true
		},
		closeModal() {
			this.modal = false
		},
		addAction(form) {
			this.$emit('submit', form)
			this.closeModal()
		},
		resetForm() {
			this.actionName = ''
			this.actionQuantity = 1
			this.actionMat = []
		},
	},
}
</script>

<style lang="scss" scoped>
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
		background-color:  var(--color-primary);
		color: var(--color-main-text);
	}

	.title{
		font-size: 16px;
		font-weight: bold;
		margin-bottom: 10px;
	}
</style>
