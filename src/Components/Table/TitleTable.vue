<template>
	<h1 id="title" class="med-text">
		{{ title }}
	</h1>
</template>

<script>
export default {
	name: 'TitleTable',
	components: {
	},
	props: {
		title: {
			type: String,
			default: 'Tutti',
		},
	},
}
</script>

<style>
	.med-text{font-size: 50px; margin:15px 0px 25px 50px; font-weight: 500;}
</style>
