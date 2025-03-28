import { defineStore } from 'pinia';
import { ref, toRaw } from 'vue';
import apolloClient from '@/apolloClient';
import { GET_ETABLISSEMENTS, GET_ETABLISSEMENT, GET_ETABLISSEMENT_BY_SLUG, CREATE_TRANSMISSION, UPDATE_TRANSMISSION } from '@/graphql/queries';
import { useMutation } from '@vue/apollo-composable';
import { useApolloClient } from "@vue/apollo-composable";


export const useEtablissementStore = defineStore('etablissement', () => {
  // Définition de l'interface Transmission
  interface Transmission {
    [x: string]: any;
    id?: string;
    message: string;
    jour: string;
    heure_debut: string;
    heure_fin: string;
    okeemien_id: string;
    enfant_id: string;
    etablissement_id: string;
  }

  // Définition des refs avec typages appropriés
  const etablissements = ref<any[]>([]);
  const etablissement = ref<any>(null);
  const enfants = ref<any[]>([]);
  const tuteurs = ref<any[]>([]);
  const okeemiens = ref<any[]>([]);
  const factures = ref<any[]>([]);
  const transmissions = ref<Transmission[]>([]);  

  // Récupérer tous les établissements
  const fetchEtablissements = async () => {
    try {
      const { data } = await apolloClient.query({ query: GET_ETABLISSEMENTS });
      etablissements.value = data.etablissements;
    } catch (error) {
      console.error('Erreur lors de la récupération des établissements', error);
    }
  };

  // Définir l'établissement sélectionné
  const setEtablissement = (selectedEtablissement: any) => {  
    etablissement.value = selectedEtablissement;
  };

  // Charger un établissement et ses données associées via son slug
  const loadDataBySlug = async (slug: any) => {
    try {
      const { data } = await apolloClient.query({ 
        query: GET_ETABLISSEMENT_BY_SLUG, 
        variables: { slug } 
      });
      if (data.etablissementBySlug) {
        etablissement.value = data.etablissementBySlug;
        enfants.value = data.etablissementBySlug.enfants;
        tuteurs.value = data.etablissementBySlug.tuteurs;
        okeemiens.value = data.etablissementBySlug.okeemiens;
        factures.value = data.etablissementBySlug.factures;
        transmissions.value = data.etablissementBySlug.transmissions.map((transmission: { okeemien: { id: any; }; enfant: { id: any; }; etablissement: { id: any; };}) => ({
          ...transmission,
          okeemien_id: transmission.okeemien?.id || '',
          enfant_id: transmission.enfant?.id || '',
          etablissement_id: transmission.etablissement?.id || '',
        })) as Transmission[];

      } else {
        console.error('Aucun établissement trouvé pour ce slug');
      }
    } catch (error) {
      console.error('Erreur lors de la récupération de l\'établissement', error);
    }
  };

  const ajouterTransmission = async (transmission: Transmission) => {
    try {
      const rawTransmission = toRaw(transmission); 
      const formattedDate = new Date(transmission.jour).toISOString().split('T')[0];
      const result = await apolloClient.mutate({
        mutation: CREATE_TRANSMISSION,
        variables: {         message: transmission.message,
          jour: formattedDate,
          heure_debut: transmission.heure_debut,
          heure_fin: transmission.heure_fin,
          okeemien_id: transmission.okeemien_id,
          enfant_id: transmission.enfant_id,
          etablissement_id: etablissement.value?.id || '' },
      });
      
      if (result.data && result.data.createTransmission) {
        const newTransmission = result.data.createTransmission as Transmission;
        newTransmission.okeemien = okeemiens.value.find(o => o.id === rawTransmission.okeemien_id);
        newTransmission.enfant = enfants.value.find(e => e.id === rawTransmission.enfant_id);
        newTransmission.etablissement = etablissement.value;
        transmissions.value = [newTransmission, ...transmissions.value];   
        return newTransmission;
      }
    } catch (error) {
      console.error("Erreur lors de l'ajout de la transmission", error);
    }
  };
  
  const modifierTransmission = async (transmission: Transmission) => {
    try {
      const rawTransmission = toRaw(transmission); 

      const formattedDate = new Date(rawTransmission.jour).toISOString().split('T')[0];

      const result = await apolloClient.mutate({
        mutation: UPDATE_TRANSMISSION,
        variables: { 
          id: rawTransmission.id, 
          message: rawTransmission.message,
          jour: formattedDate,
          heure_debut: rawTransmission.heure_debut,
          heure_fin: rawTransmission.heure_fin,
          okeemien_id: rawTransmission.okeemien.id,
          enfant_id: rawTransmission.enfant.id,
          etablissement_id: rawTransmission.etablissement.id 
         },
      });
      
      if (result.data && result.data.updateTransmission) {
        const index = transmissions.value.findIndex(t => t.id === rawTransmission.id);
        if (index !== -1) {
          transmissions.value[index] = { ...transmissions.value[index], ...result.data.updateTransmission };
        }
      }
    }  catch (error) {
      console.error('Erreur lors de la modification de la transmission', error);
    }
  };

  return {
    etablissements,
    etablissement,
    enfants,
    tuteurs,
    okeemiens,
    transmissions,
    factures,
    fetchEtablissements,
    setEtablissement,
    loadDataBySlug,
    ajouterTransmission,
    modifierTransmission
  };
});