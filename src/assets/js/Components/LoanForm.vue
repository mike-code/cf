<template>
<div><a-spin :spinning="loading"><a-row type="flex" justify="center"><a-col :span="12">
	<h3>Loan Application</h3>

	<a-form :form="form" layout="horizontal">
		<a-form-item has-feedback label="First Name" :label-col="{span: 5}" :wrapper-col="{span: 12}">
			<a-input size="large" v-decorator="['First Name', {rules: [{required: true}]}]"/>
		</a-form-item>

		<a-form-item has-feedback label="Last Name" :label-col="{span: 5}" :wrapper-col="{span: 12}">
			<a-input size="large" v-decorator="['Last Name', {rules: [{required: true}]}]"/>
		</a-form-item>

		<a-form-item has-feedback label="Street" :label-col="{span: 5}" :wrapper-col="{span: 12}">
			<a-input size="large" v-decorator="['Street', {rules: [{required: true}]}]"/>
		</a-form-item>

		<a-form-item has-feedback label="Zip Code" :label-col="{span: 5}" :wrapper-col="{span: 12}">
			<a-input-number :precision="0" size="large" v-decorator="['Zip Code', {rules: [{required: true, type: 'integer'}]}]" />
		</a-form-item>

		<a-form-item has-feedback label="City" :label-col="{span: 5}" :wrapper-col="{span: 12}">
			<a-input size="large" v-decorator="['City', {rules: [{required: true}]}]"/>
		</a-form-item>

		<a-form-item has-feedback label="Loan Amount" :label-col="{span: 5}" :wrapper-col="{span: 12}">
			<a-input-number :min="1" :max="10000" :precision="2" size="large" v-decorator="['Loan Amount', {rules: [{required: true, type: 'number'}]}]" />
		</a-form-item>

		<a-form-item has-feedback label="Loan Term" :label-col="{span: 5}" :wrapper-col="{span: 12}">
			<a-input-number :min="1" :max="60" :precision="0" size="large" v-decorator="['Loan Term', {rules: [{required: true, type: 'integer'}]}]" />
		</a-form-item>

		<a-form-item>
			<a-button @click="generate">Generate random data</a-button>

			<a-button type="primary" @click="validate">Submit Application</a-button>
		</a-form-item>
	</a-form>

</a-col></a-row></a-spin></div>
</template>

<script>
	import axios from 'axios'
	import _ from 'lodash'
	import faker from 'faker'

	export default
	{
		props: ['route_store'],

		data() {
			return {
				form: this.$form.createForm(this),
				loading: false,
			}
		},

		methods: {
			generate()
			{
				this.form.setFieldsValue({'First Name': faker.name.firstName()})
				this.form.setFieldsValue({'Last Name': faker.name.lastName()})
				this.form.setFieldsValue({'Street': faker.address.streetName()})
				this.form.setFieldsValue({'Zip Code': parseInt(faker.address.zipCode('#####'))})
				this.form.setFieldsValue({'City': faker.address.city()})
				this.form.setFieldsValue({'Loan Amount': parseFloat(faker.finance.amount(1000,10000,2))})
				this.form.setFieldsValue({'Loan Term': parseInt(faker.random.number({min:1, max:60}))})
			},

			validate()
			{
				this.form.validateFields( (errors) => {
					if (!!errors) return;

					this.submit()
				})
			},

			submit()
			{
				this.loading = true

				let formData = _.mapKeys(this.form.getFieldsValue(), (v, k) => _.camelCase(k))

				axios.post(this.route_store, formData)
					.then((response) => {
						this.$notification['success']({message: 'Application has been submitted', style: {top: "48px"}})
						this.form.resetFields()
					})
					.catch((err) => {
						this.$notification['error']({message: 'Could not submit the application', style: {top: "48px"}})
					})
					.finally(() => { this.loading = false })
			}
		}
	}
</script>
