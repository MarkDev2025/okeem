import { gql } from '@apollo/client/core';

// Récupérer tous les établissements
export const GET_ETABLISSEMENTS = gql`
  query {
    etablissements {
      id
      nom
      slug
      type
      lieu
      nom_responsable
    }
  }
`;

// Récupérer un établissement par slug
export const GET_ETABLISSEMENT_BY_SLUG = gql`
  query ($slug: String!) {
    etablissementBySlug(slug: $slug) {
      id
      nom
      slug
      type
      lieu
      nom_responsable
      enfants {
        id
        prenom
        nom
        slug
        date_naissance
        tuteurs {
          id
        }
        transmissions {
          id
          message
          jour
          heure_debut
          okeemien {
            id
            nom
            prenom
            slug
          }
        }
      } 
      tuteurs {
        id
        prenom
        nom
        telephone
        email
        slug
        enfants {
          id
        }
        factures {
          id
          montant
          statut
        }
      }
      okeemiens {
        id
        prenom
        nom
        slug
        telephone
        email
      }
      transmissions {
        id
        message
        enfant {
          id
          prenom
          nom
          slug
        }
        jour
        okeemien {
          id
        }
        etablissement {
          id
        }
        jour
        heure_debut
        heure_fin
      }      
      factures {
        id
        montant
        statut
        tuteur {
          id
        }
      }
    }
  }
`;

// Récupérer un établissement par ID
export const GET_ETABLISSEMENT = gql`
  query ($id: ID!) {
    etablissement(id: $id) {
      id
      nom
      slug
      type
      lieu
      nom_responsable
      enfants {
        id
        prenom
        nom
        slug
      }
      tuteurs {
        id
        prenom
        nom
        slug
      }
      okeemiens {
        id
        prenom
        nom
        slug
      }
      transmissions {
        id
        message
        enfant {
          id
          prenom
          nom
        }
      }
    }
  }
`;

export const CREATE_TRANSMISSION = gql`
  mutation CreateTransmission($message: String!, $jour: Date!, $heure_debut: String!, $heure_fin: String!, $okeemien_id: ID!, $enfant_id: ID!, $etablissement_id: ID!,) {
    createTransmission(
      message: $message
      jour: $jour
      heure_debut: $heure_debut
      heure_fin: $heure_fin
      etablissement_id: $etablissement_id
      okeemien_id: $okeemien_id
      enfant_id: $enfant_id
    ) {
      id
      message
      jour
      heure_debut
      heure_fin
      etablissement_id
      okeemien_id
      enfant_id
    }
  }
`;

export const UPDATE_TRANSMISSION = gql`
  mutation UpdateTransmission(
    $id: ID!,
    $message: String!,
    $jour: Date!,
    $heure_debut: String!,
    $heure_fin: String!,
    $etablissement_id: ID!,
    $okeemien_id: ID!,
    $enfant_id: ID!
  ) {
    updateTransmission(
      id: $id,
      message: $message,
      jour: $jour,
      heure_debut: $heure_debut,
      heure_fin: $heure_fin,
      etablissement_id: $etablissement_id,
      okeemien_id: $okeemien_id,
      enfant_id: $enfant_id
    ) {
      id
      message
      jour
      heure_debut
      heure_fin
      etablissement_id
      okeemien_id
      enfant_id
    }
  }
`;


