export interface Transaction {
  id: string,
  amount: number,
  order_id: string,
  timestamp: string,
  type: 'deposite' | 'withdraw',
  status: "1" | "2",
  user_fullname: string
}
