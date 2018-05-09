import React from 'react';
import ReactDOM from 'react-dom';
import { toIdValue } from 'apollo-utilities';
import { ApolloProvider } from 'react-apollo';
import { ApolloClient } from 'apollo-client';
import { HttpLink } from 'apollo-link-http';
import { InMemoryCache } from 'apollo-cache-inmemory';
import { Route, Switch } from 'react-router';
import { BrowserRouter as Router } from 'react-router-dom';

import PartsContainer from './product/containers/PartsContainer';
import PartContainer from './product/containers/PartContainer';

function dataIdFromObject (o) {
  if (o.__typename && o.id) {
    return `${o.__typename}:${o.id}`;
  }
  return null;
}

const client = new ApolloClient({
    link: new HttpLink({ uri: window.URLS.graphql, credentials: 'same-origin' }),
    cache: new InMemoryCache({
      dataIdFromObject,
      cacheResolvers: {
        Query: {
          part: (_, args) => toIdValue(`Part:${args.id}`),
          category: (_, args) => toIdValue(`Category:${args.id}`),
        },
      },
    })
});

ReactDOM.render(
    <ApolloProvider client={client}>
        <Router basename={window.URLS.home}>
            <Switch>
                <Route exact path="/:partId" render={(props) => {
                    return <PartContainer back={props.history.goBack} partId={parseInt(props.match.params.partId)}></PartContainer>
                }}/>
                <Route exact path="/" render={(props) => {
                    return <PartsContainer></PartsContainer>
                }}/>
            </Switch>
        </Router>
    </ApolloProvider>,
    document.getElementById('root')
);