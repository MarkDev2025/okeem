import { ApolloClient, InMemoryCache, createHttpLink } from '@apollo/client/core';
import { BACKEND_URL } from '@/config'


const httpLink = createHttpLink({
  uri: BACKEND_URL+'/graphql', 
});

const apolloClient = new ApolloClient({
  link: httpLink,
  cache: new InMemoryCache(),
});

apolloClient.cache.reset();

export default apolloClient;
