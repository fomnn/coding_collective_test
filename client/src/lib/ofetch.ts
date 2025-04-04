import { ofetch } from "ofetch";

const baseURL = "http://localhost:8000"

const apiFetch = ofetch.create({
  baseURL,
})

export default apiFetch
