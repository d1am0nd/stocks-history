import React from 'react';
import radium from 'radium';

import {fetchStocks, fetchMonths, fetchDays} from './api/stock';
import Graph from './components/graphs/Graph';

import {
  wrapper as wrapperStyle,
} from './styles/layout';

@radium()
class Main extends React.Component {
  constructor() {
    super();
    this.state = {
      stocks: [],
      data: [],
      selectedStock: {},
      selectedType: 'months',
    };

    fetchStocks()
      .then(res => {
        const newState = {
          stocks: res.data,
          selectedStock: typeof res.data[0] !== 'undefined' ?
            res.data[0] : {},
        };
        this.setState(newState);
        this.fetchStock(newState.selectedStock.symbol, this.state.selectedType);
      })
      .catch(err => {
        console.log(err);
      });
  }

  fetchStock(symbol, type) {
    return new Promise((resolve, reject) => {
      let key = null;
      let func = null;
      switch (type) {
        case 'months': {
          func = fetchMonths;
          key = 'months';
          break;
        }
        case 'days': {
          func = fetchDays;
          key = 'days';
          break;
        }
      }
      console.log('fetching', type);
      func(symbol)
        .then(res => {
          this.setState({
            data: res.data[key],
          });
          resolve(res);
        })
        .catch(err => {
          console.log(err);
          reject(err);
        });
    });
  }

  handleTypeChange(e) {
    const newType = e.target.value;
    this.setState({
      selectedType: newType,
    });
    this.fetchStock(this.state.selectedStock.symbol, newType);
  }

  handleStockChange(e) {
    const newSymbol = e.target.value;
    this.setState({
      selectedStock: this.state.stocks.find(s => {
        return s.symbol === newSymbol;
      }),
    });
    this.fetchStock(newSymbol, this.state.selectedType);
  }

  render() {
    return (
      <div style={wrapperStyle()}>
        <Graph stock={this.state.selectedStock} data={this.state.data}/>
        <select
          onChange={e => this.handleStockChange(e)}
          value={this.state.selectedStock.symbol}>
          {this.state.stocks.map((s, i) => {
            return (
              <option
                key={`stock-opt-${i}`}
                value={s.symbol}>
                {s.name} ({s.symbol.toUpperCase()})
              </option>
            );
          })}
        </select>
        <select
          onChange={e => this.handleTypeChange(e)}
          value={this.state.selectedType}>
          <option
            key={`stock-type-1`}
            value={'months'}>
            By month
          </option>
          <option
            key={`stock-type-2`}
            value={'days'}>
            By day
          </option>
        </select>
      </div>
    );
  }
}

export default Main;
