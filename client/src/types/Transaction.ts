export interface Transaction {
  id: string,
  amount: number,
  order_id: string,
  timestamp: string,
  type: 'deposite' | 'withdraw',
  user_fullname: string
}
