import {
    format,
    parseISO,
    isToday,
    isYesterday,
    subDays,
    isSameDay,
    differenceInCalendarDays,
    formatDistanceToNow,
    differenceInMonths, 
    differenceInYears
  } from 'date-fns';
  import { fr } from 'date-fns/locale';
  
  export function formatTransmissionDate(dateString: string): string {
    const date = parseISO(dateString);
    const today = new Date();
  
    if (isToday(date)) return "Aujourd'hui";
    if (isYesterday(date)) return "Hier";
    if (isSameDay(date, subDays(today, 2))) return "Avant-hier";
  
    const diff = differenceInCalendarDays(today, date);
  
    // Si la date est dans les 7 derniers jours
    if (diff <= 7) {
      return `il y a ${formatDistanceToNow(date, { locale: fr, addSuffix: false })}`;
    }
  
    // Sinon : affichage long
    return format(date, "eeee d MMMM yyyy", { locale: fr }).charAt(0).toUpperCase() + format(date, "eeee d MMMM yyyy", { locale: fr }).slice(1);
  }
  
  export function formatDateFR(dateString: string): string {
    const date = parseISO(dateString)
    return format(date, "d MMMM yyyy", { locale: fr })
  }

  export function calculAge(dateNaissance: string): string {
    const naissance = parseISO(dateNaissance)
    const aujourdHui = new Date()
  
    const totalMois = differenceInMonths(aujourdHui, naissance)
  
    if (totalMois < 36) {
      return `${totalMois} mois`
    }
  
    const annees = differenceInYears(aujourdHui, naissance)
    const moisRestants = totalMois - (annees * 12)
  
    return moisRestants > 0
      ? `${annees} ans et ${moisRestants} mois`
      : `${annees} ans`
  }
  