import axios from 'axios';
import {BASE_URL} from './params';

export const fetchStocks = function() {
  return axios.get(`${BASE_URL}`);
};
export const fetchMonths = function(stock) {
  return axios.get(`${BASE_URL}/${stock}/months`);
};
export const fetchDays = function(stock) {
  return axios.get(`${BASE_URL}/${stock}/days`);
};
