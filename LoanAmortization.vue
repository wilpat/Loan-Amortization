<template>
	<div class="container">
		<div class="row">
			<div class="col-md-3 ">
			    <div class="list-group ">
	              <a href="admin" class="list-group-item list-group-item-action">Admin</a>          
		            <a href="dashboard" class="list-group-item list-group-item-action">Dashboard</a>
	            	<a href="#" class="list-group-item list-group-item-action active">Loan Amortization</a>
	            </div> 
			</div>
			<div class="col-md-9">
			    <div class="card">
			        <div class="card-body">
			            <div class="row">
			                <div class="col-md-12">
			                    <h4>You'd need at least 3 fields to calculate the fourth.</h4>
			                    <p style="font-size: 14px; color: green">You'd need the balance, interest and monthly payment for the schedule.</p>
			                    <hr>
			                </div>
			            </div>
			            <div class="row">
			                <div class="col-md-9">
			                	<div class="field has-addons">
								  <label class="label">Principal : </label>
								  <div class="control is-expanded">
								    <input class="input" type="text" placeholder="Loan amount plus fee(if any)" v-model="principal" :disabled="lock">
								  </div>
								  <div class="control">
								    <a class="button is-info" style="color: white" @click="calc_principal" :disabled="lock">
								      Calulate
								    </a>
								  </div>
								  <p class="help is-error" v-if="pricipalError">The Principal is needed</p>
								</div>

								<!-- <div class="field has-addons">
								  <label class="label">Fee(% of loan) : </label>
								  <div class="control">
								    <input class="input" type="text" placeholder="Text input">
								  </div>
								  <div class="control">
								    <a class="button is-info" style="color: white">
								      Calulate
								    </a>
								  </div>
								  <p class="help is-error" v-if="feeError">The fee is needed</p>
								</div> -->

								<div class="field has-addons">
								  <label class="label">Interest rate : </label>
								  <div class="control is-expanded">
								    <input class="input" type="text" placeholder="% per payment" v-model="interest" :disabled="lock">
								  </div>
								  <div class="control">
								    <a class="button is-info" style="color: white" @click=" calc_interest " :disabled="lock">
								      Calulate
								    </a>
								  </div>
								  <p class="help is-error" v-if="interestError">The interest rate is needed</p>
								</div>

								<div class="field has-addons">
								  <label class="label">Number Of Payments(Months)</label>
								  <div class="control is-expanded">
								    <input class="input" type="text" placeholder="Number of payments" v-model="paymentNumber" :disabled="lock">
								  </div>
								  <div class="control">
								    <a class="button is-info" style="color: white" @click="calc_paymentNumber" :disabled="lock">
								      Calulate
								    </a>
								  </div>
								  <p class="help is-error" v-if="paymentNumberError">The number of payments is needed</p>
								</div>


								<div class="field has-addons">
								  <label class="label">Monthly Payment</label>
								  <div class="control is-expanded">
								    <input class="input" type="text" placeholder="Monthly Payment" v-model="monthlyPayment" :disabled="lock">
								  </div>
								  <div class="control">
								    <a class="button is-info" style="color: white" @click=" calc_payment() " :disabled="lock">
								      Calulate
								    </a>
								  </div>
								  <p class="help is-error" v-if="monthlyPaymentError">The monthly payment is needed</p>
								</div>

								<div class="field is-grouped">
								  <div class="control">
								    <button class="button is-link" @click="reset">New Values</button>
								  </div>
								  <div class="control">
								    <button class="button is-link" @click="print_schedule()">Payment Schedule</button>
								  </div>
								</div>
			                </div>
			                <div class="col-md-12">
								<table class="table is-hoverable is-striped" v-if="schedules.length">
									<thead>
										<tr>
											<th>S/N</th>
											<th>Opening Balance B/F</th>
											<th>Monthly Payment</th>
											<th>Principal</th>
											<th>Interest</th>
											<th>Balance</th>
										</tr>
									</thead>

									<tbody>

										<tr v-for="schedule in schedules">
											<td>{{ Math.round(schedule.count) }}</td>
											<td>{{ Math.round(schedule.balanceBF) }}</td>
											<td>{{ Math.round(schedule.payment) }}</td>
											<td>{{ Math.round(schedule.principal) }}</td>
											<td>{{ Math.round(schedule.interest) }}</td>
											<td>{{ Math.round(schedule.balance) }}</td>
										</tr>

									</tbody>

									<tfoot>
										<tr>
											<th></th>
											<th> Totals:</th>
											<th>{{ Math.round(totPayment) }}</th>
											<th> {{ Math.round(totPrincipal) }} </th>
											<th> {{ Math.round(totInterest) }} </th>
											<th></th>
										</tr>
									</tfoot>
								</table>
							</div>
			            </div>
			            
			        </div>
			    </div>
			</div>
		</div>
	</div>
	
</template>

<script type="text/javascript">
	export default {
		mounted(){
			
		},
		data(){
			return {
				user:{

				},
				pricipalError:false,
				interestError:false,
				monthlyPaymentError:false,
				paymentNumberError:false,
				principal: 154350,
				paymentNumber:9,
				interest:5.3,
				monthlyPayment:22007,
				schedules:[],
				totPayment:'',
				totInterest:'',
				totPrincipal:'',
				lock:false
			}
		},
		methods:{
			
			reset(){
				this.principal = '';
				this.paymentNumber = '';
				this.interest = '';
				this.monthlyPayment = '';
				this.lock = false;
				this.schedules=[];
			},
			viewSchedule(){

			},
			calc_principal(){
				if(this.interest == ""){
					this.interestError = true;
				}
				else if(this.paymentNumber == ""){
					this.paymentNumberError = true;
				}
				else if(this.monthlyPayment == ""){
					this.monthlyPaymentError = true;
				} else{
					var int    = this.interest / 100;        //convert to percentage
					var value1 = (Math.pow((1 + int), this.paymentNumber)) - 1;
					var value2 = int * Math.pow((1 + int), this.paymentNumber);
					var pv     = this.monthlyPayment * (value1 / value2);
					this.principal = pv.toFixed(2);
				}
				
				
			},
			calc_paymentNumber(){
				if(this.principal == ""){
					this.pricipalError = true;
				}
				else if(this.interest == ""){
					this.interestError = true;
				}
				else if(this.monthlyPayment == ""){
					this.monthlyPaymentError = true;
				} else{
					var int    = this.interest / 100;        //convert to percentage
					var value1 = Math.log(1 - int * (this.principal / this.monthlyPayment));
					var value2 = Math.log(1 + int);
					var payno  = value1 / value2;
					payno  = Math.abs(payno);
					this.paymentNumber  = payno.toFixed(0);
				}
			},
			calc_interest(){
				if(this.principal == ""){
					this.pricipalError = true;
				}
				else if(this.paymentNumber == ""){
					this.paymentNumberError = true;
				}
				else if(this.monthlyPayment == ""){
					this.monthlyPaymentError = true;
				} 
				else{
					var GuessHigh = 100; //Maximum Value
					var GuessMiddle = 2.5;//First guess
					var GuessLow = 0;//Minimum value
					var GuessPMT = 0; // Result payment from test calculation

					do{
						GuessPMT = this.calc_payment(this.principal, this.paymentNumber, GuessMiddle, 6, 1);
						if(GuessPMT > this.monthlyPayment){//Guess is too high
							GuessHigh   = GuessMiddle;
						   	GuessMiddle = GuessMiddle + GuessLow;
						    GuessMiddle = GuessMiddle / 2;
						}
						if(GuessPMT < this.monthlyPayment){//Guess is too low
							GuessLow   = GuessMiddle;
						   	GuessMiddle = GuessMiddle + GuessHigh;
						    GuessMiddle = GuessMiddle / 2;
						}
						if(GuessMiddle == GuessHigh){
							break;
						}
						if(GuessMiddle == GuessLow){
							break;
						}
						var int = GuessMiddle.toFixed(9);
						if(int == 0){
							alert('Oops! You provided one or more incorrect values.');
							break;
						}
						// console.log(GuessMiddle);
					}
					while( GuessPMT !== this.monthlyPayment )
					this.interest = GuessMiddle.toFixed(9);
				}
			},
			calc_payment(pv = this.principal, payno = this.paymentNumber, int = this.interest, accuracy = 2,test=0){
				if(pv == ""){
					this.pricipalError = true;
				}
				else if(payno == ""){
					this.paymentNumberError = true;
				}
				else if(int == ""){
					this.interestError = true;
				} 
				else{
					//******************************************
					//            INT * ((1 + INT) ** PAYNO)
					// PMT = PV * --------------------------
					//             ((1 + INT) ** PAYNO) - 1
					//******************************************

					int    = int / 100;    // convert to a percentage
					var value1 = int * Math.pow((1 + int), payno);
					var value2 = Math.pow((1 + int), payno) - 1;
					var pmt    = pv * (value1 / value2);
					// accuracy specifies the number of decimal places required in the result
					if(!test){
						this.monthlyPayment  = pmt.toFixed(accuracy);
					}
					// console.log(pmt.toFixed(accuracy));

					return pmt.toFixed(accuracy);
				}
			},

			print_schedule(balance = parseFloat(this.principal), rate = this.interest, payment = parseFloat(this.monthlyPayment)){
				if( balance == ""){
					this.pricipalError = true;
				}
				else if(rate == ""){
					this.interestError = true;
				}
				else if(payment == ""){
					this.monthlyPaymentError = true;
				} 
				else
				{
					var count = 0;
					var schedules = [];
					var totPayment = 0;
					var totInterest = 0;
					var totPrincipal = 0;
					do {
					   count++;
					   // calculate interest on outstanding balance
					   var interest = balance * rate/100;

					   // what portion of payment applies to principal?
					   var principal = payment - interest;

					   // watch out for balance < payment
					   if (balance < payment) {
					      principal = balance;
					      payment   = interest + principal;
					   } // if
					  

					   //get the balance brought forward
					   var balanceBF = balance;

					   // reduce balance by principal paid
					   balance = balance - principal;


					   // watch for rounding error that leaves a tiny balance
					   if (balance < 0) {
					      principal = principal + balance;
					      interest  = interest - balance;
					      balance   = 0;
					   } // if

					   schedules.push({
					   	balanceBF,
					   	balance,
					   	payment,
					   	interest,
					   	principal,
					   	count
					   });


					   totPayment   = totPayment + payment;
					   totInterest  = totInterest + interest;
					   totPrincipal = totPrincipal + principal;

					   if (payment < interest) {
					      alert('Payment < Interest amount - rate is too high, or payment is too low')
					      break;
					   } // if

					} while (balance > 0);
					this.schedules = schedules;
					this.totPrincipal = totPrincipal;
					this.totInterest = totInterest;
					this.totPayment = totPayment;
					this.lock=true;
				}
			}
		}
	}
</script>

<style type="text/css" scoped>
	
	a{
		text-decoration:none;
	}
	.is-error{
		color: red;
		font-weight: bold;
	}
	table{
		margin-top: 5%;
		border-top: 1px solid #ccc;
	}
</style>